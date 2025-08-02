<?php

namespace App\Observers;

use App\Events\EventRegistrationUpdated;
use App\Models\EventRegistration;

class EventRegistrationObserver
{
    /**
     * Handle the EventRegistration "created" event.
     */
    public function created(EventRegistration $eventRegistration): void
    {
        EventRegistrationUpdated::dispatch($eventRegistration->event);
    }

    /**
     * Handle the EventRegistration "deleted" event.
     */
    public function deleted(EventRegistration $eventRegistration): void
    {
        EventRegistrationUpdated::dispatch($eventRegistration->event);
    }
}
