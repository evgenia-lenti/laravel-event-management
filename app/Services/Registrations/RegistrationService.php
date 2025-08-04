<?php

namespace App\Services\Registrations;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class RegistrationService
{
    /**
     * @throws Throwable
     */
    public function registerUserToEvent(array $data): EventRegistration
    {
        return DB::transaction(function () use ($data) {
            // Find the event with a lock for update
            $event = Event::lockForUpdate()->findOrFail($data['event_id']);
            $user = User::findOrFail($data['user_id']);

            // Check if the event has reached its capacity
            if ($event->current_registrations_count >= $event->capacity) {
                throw ValidationException::withMessages([
                    'event_id' => ['This event has reached its maximum capacity.']
                ]);
            }

            // Check if already registered for the specific event
            if (!$event->registrations()->where('user_id', $user->id)->exists()) {
                // Attach the user to the event
                $event->registrations()->attach($user->id);
            }

            // Return the registration model for API response
            return EventRegistration::where([
                'event_id' => $event->id,
                'user_id' => $user->id
            ])->first();
        });
    }

    public function unregister(EventRegistration $registration): void
    {
        $event = Event::findOrFail($registration->event_id);
        $event->registrations()->detach($registration->user_id);
    }

    // Get all registrations for a user
    public function getUserRegistrations(User $user): Collection
    {
        return EventRegistration::with(['event', 'user'])
            ->where('user_id', $user->id)
            ->whereHas('event', function($query) {
                $query->orderBy('event_date', 'desc');
            })
            ->get();
    }
}
