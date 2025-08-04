<?php

namespace Api\v1\Registrations;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCannotRegisterForFullCapacityEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_register_for_event_at_exact_capacity(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a published event that is exactly at capacity
        $event = Event::factory()->create([
            'status' => EventStatus::Published,
            'capacity' => 5,
            'current_registrations_count' => 5,
        ]);

        // Authenticate the user
        Sanctum::actingAs($user);

        // Make request to the API endpoint
        $response = $this->postJson("/api/v1/events/{$event->id}/register");

        // Assert validation error response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['event_id']);
        $response->assertJsonPath('errors.event_id.0', 'This event has reached its maximum capacity.');
    }

    public function test_capacity_check_is_performed_with_database_lock(): void
    {
        // Create two users
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        // Create a published event with only one spot left
        $event = Event::factory()->create([
            'status' => EventStatus::Published,
            'capacity' => 1,
            'current_registrations_count' => 0,
        ]);

        // Authenticate the first user and register
        Sanctum::actingAs($firstUser);
        $firstResponse = $this->postJson("/api/v1/events/{$event->id}/register");
        $firstResponse->assertStatus(200);

        // Authenticate the second user and try to register
        Sanctum::actingAs($secondUser);
        $secondResponse = $this->postJson("/api/v1/events/{$event->id}/register");

        // Second registration should fail due to capacity
        $secondResponse->assertStatus(422);
        $secondResponse->assertJsonValidationErrors(['event_id']);

        // Verify only one registration exists in the database
        $this->assertDatabaseCount('event_registrations', 1);
        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'user_id' => $firstUser->id,
        ]);
    }
}
