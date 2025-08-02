<?php

namespace App\Services\Events;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventService
{
    public function createEvent(array $data): Event
    {
        $data = $this->transformEventData($data);

        return Event::create($data);
    }

    public function updateEvent(Event $event, array $data): Event
    {
        $data = $this->transformEventData($data);

        $event->update($data);
        return $event;
    }

    public function deleteEvent(Event $event): void
    {
        $event->delete();
    }

    public function registerUserToEvent(Event $event, User $user): void
    {
        $event->registrations()->attach($user->id);
    }

    public function unregisterUserFromEvent(Event $event, User $user): void
    {
        $event->registrations()->detach($user->id);
    }

    private function transformEventData(array $data): array
    {
        if (isset($data['event_date'])) {
            $data['event_date'] = Carbon::parse($data['event_date']);
        }

        return $data;
    }
}
