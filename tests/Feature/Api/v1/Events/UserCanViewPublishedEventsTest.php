<?php

namespace Tests\Feature\Api\v1\Events;

use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanViewPublishedEventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_published_events_via_api(): void
    {
        // Create published events
        $publishedEvents = Event::factory()->count(3)->create([
            'status' => EventStatus::Published,
        ]);

        // Create draft events
        Event::factory()->count(2)->create([
            'status' => EventStatus::Draft,
        ]);

        // Create cancelled events
        Event::factory()->count(2)->create([
            'status' => EventStatus::Cancelled,
        ]);

        // Make request to the API endpoint
        $response = $this->getJson('/api/v1/events');

        // Assert successful response
        $response->assertStatus(200);

        // Assert the structure of the response - without status and message at root level
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'eventDate',
                    'location',
                    'capacity',
                    'status' => [
                        'value',
                        'label'
                    ],
                    'currentRegistrationsCount',
                    'can' => [
                        'update',
                        'delete'
                    ]
                ]
            ],
            'links',
            'meta'
        ]);

        // Assert only published events are returned (3 events)
        $response->assertJsonCount(3, 'data');

        // Verify that all returned events have 'published' status
        $responseData = $response->json('data');
        foreach ($responseData as $event) {
            $this->assertEquals('published', $event['status']['value']);
        }

        // Verify that the published events we created are in the response
        foreach ($publishedEvents as $event) {
            $response->assertJsonFragment([
                'id' => $event->id,
                'title' => $event->title
            ]);
        }
    }

    public function test_user_can_view_single_published_event_via_api(): void
    {
        // Create a published event
        $publishedEvent = Event::factory()->create([
            'status' => EventStatus::Published,
        ]);

        // Make request to the API endpoint
        $response = $this->getJson("/api/v1/events/{$publishedEvent->id}");

        // Assert successful response
        $response->assertStatus(200);

        // Assert the structure of the response
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'event' => [
                    'id',
                    'title',
                    'description',
                    'eventDate',
                    'location',
                    'capacity',
                    'status',
                    'currentRegistrationsCount',
                    'can'
                ]
            ]
        ]);

        // Verify the event details
        $response->assertJsonPath('data.event.id', $publishedEvent->id);
        $response->assertJsonPath('data.event.title', $publishedEvent->title);
    }

    public function test_user_cannot_view_unpublished_event_via_api(): void
    {
        // Create a draft event
        $draftEvent = Event::factory()->create([
            'status' => EventStatus::Draft,
        ]);

        // Make request to the API endpoint
        $response = $this->getJson("/api/v1/events/{$draftEvent->id}");

        // Assert forbidden response (403)
        $response->assertStatus(403);
        $response->assertJsonPath('message', 'This action is unauthorized.');
    }
}
