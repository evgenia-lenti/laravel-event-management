<?php

namespace App\Services\Registrations;

use App\Models\EventRegistration;

class RegistrationService
{
    public function registerUserToEvent(array $data): EventRegistration
    {
        return EventRegistration::query()
            ->firstOrCreate([
                'event_id' => $data['event_id'],
                'user_id' => $data['user_id']
            ]);
    }

    public function unregister(EventRegistration $registration): void
    {
        $registration->delete();
    }
}
