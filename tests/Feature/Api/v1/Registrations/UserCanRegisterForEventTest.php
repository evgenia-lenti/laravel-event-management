<?php

namespace Api\v1\Registrations;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCanRegisterForEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_register_for_event(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a published event with available capacity
        $event = Event::factory()->create([
            'status' => EventStatus::Published,
            'capacity' => 10,
            'current_registrations_count' => 0,
        ]);

        // Authenticate the user using Sanctum
        Sanctum::actingAs($user);

        // Make request to the API endpoint
        $response = $this->postJson("/api/v1/events/{$event->id}/register");

        // Assert successful response
        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');
        $response->assertJsonPath('message', 'Successfully registered for the event.');

        // Assert the structure of the response
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'registration' => [
                    'id',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'event' => [
                        'id',
                        'title',
                    ],
                    'createdAt',
                    'can' => [
                        'delete'
                    ]
                ]
            ]
        ]);

        // Verify the registration was created in the database
        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_register_for_event(): void
    {
        // Create a published event
        $event = Event::factory()->create([
            'status' => EventStatus::Published,
            'capacity' => 10,
            'current_registrations_count' => 0,
        ]);

        // Make request to the API endpoint without authentication
        $response = $this->postJson("/api/v1/events/{$event->id}/register");

        // Assert unauthorized response
        $response->assertStatus(401);
    }

    public function test_user_cannot_register_for_full_event(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a published event that has reached capacity
        $event = Event::factory()->create([
            'status' => EventStatus::Published,
            'capacity' => 10,
            'current_registrations_count' => 10,
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

    public function test_user_cannot_register_for_unpublished_event(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a draft event
        $event = Event::factory()->create([
            'status' => EventStatus::Draft,
            'capacity' => 10,
            'current_registrations_count' => 0,
        ]);

        // Authenticate the user
        Sanctum::actingAs($user);

        // Make request to the API endpoint
        $response = $this->postJson("/api/v1/events/{$event->id}/register");

        // Assert forbidden response (403)
        $response->assertStatus(403);
        $response->assertJsonPath('message', 'This action is unauthorized.');
    }

    public function test_user_cannot_register_for_same_event_twice(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a published event
        $event = Event::factory()->create([
            'status' => EventStatus::Published,
            'capacity' => 10,
            'current_registrations_count' => 0,
        ]);

        // Authenticate the user
        Sanctum::actingAs($user);

        // Register for the event first time
        $this->postJson("/api/v1/events/{$event->id}/register");

        // Try to register again
        $response = $this->postJson("/api/v1/events/{$event->id}/register");

        // The registration should still be successful as the controller handles duplicates
        $response->assertStatus(200);

        // But there should only be one registration in the database
        $this->assertDatabaseCount('event_registrations', 1);
    }
}
