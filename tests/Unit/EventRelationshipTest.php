<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_has_registrations_relationship(): void
    {
        // Create a user and an event
        $user = User::factory()->create();
        $event = Event::factory()->create();

        // Create a registration linking the user and event
        $event->registrations()->attach($user->id);

        // Refresh the event model to get the latest data
        $event->refresh();

        // Assert that the registrations relationship exists and works correctly
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $event->registrations);
        $this->assertCount(1, $event->registrations);
        $this->assertTrue($event->registrations->contains($user));
    }
}
