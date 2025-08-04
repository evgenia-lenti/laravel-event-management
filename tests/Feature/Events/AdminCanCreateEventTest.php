<?php

namespace Tests\Feature\Events;

use App\Enums\EventStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCanCreateEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_event_creation_page(): void
    {
        // Create and authenticate an admin user
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.events.create'));

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_event_creation_page(): void
    {
        // Create and authenticate a regular user
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.events.create'));

        $response->assertStatus(403); // Forbidden
    }

    public function test_admin_can_create_event(): void
    {
        // Create and authenticate an admin user
        $admin = User::factory()->admin()->create();

        $eventData = [
            'title' => 'Test Event',
            'description' => 'This is a test event description',
            'event_date' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'location' => 'Test Location',
            'capacity' => 100,
            'status' => EventStatus::Published->value,
        ];

        $response = $this->actingAs($admin)->post(route('admin.events.store'), $eventData);

        $response->assertRedirect(route('admin.events.index'));
        $response->assertSessionHas('success', 'Event created successfully.');

        // Verify the event was created in the database
        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'location' => 'Test Location',
            'capacity' => 100,
        ]);
    }

    public function test_admin_event_creation_with_invalid_data(): void
    {
        // Create and authenticate an admin user
        $admin = User::factory()->admin()->create();

        $invalidEventData = [
            'title' => '', // Empty title to trigger validation error
            'description' => 'This is a test event description',
            'event_date' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'location' => 'Test Location',
            'capacity' => 100,
            'status' => EventStatus::Published->value,
        ];

        $response = $this->actingAs($admin)->post(route('admin.events.store'), $invalidEventData);

        $response->assertSessionHasErrors('title');
        $response->assertRedirect();
    }

    public function test_non_admin_cannot_create_event(): void
    {
        // Create and authenticate a regular user
        $user = User::factory()->create();

        $eventData = [
            'title' => 'Test Event',
            'description' => 'This is a test event description',
            'event_date' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'location' => 'Test Location',
            'capacity' => 100,
            'status' => EventStatus::Published->value,
        ];

        $response = $this->actingAs($user)->post(route('admin.events.store'), $eventData);

        $response->assertStatus(403); // Forbidden

        // Verify the event was not created in the database
        $this->assertDatabaseMissing('events', [
            'title' => 'Test Event',
        ]);
    }
}
