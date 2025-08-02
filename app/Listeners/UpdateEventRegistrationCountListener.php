<?php

namespace App\Listeners;

use App\Events\EventRegistrationUpdated;
use App\Jobs\UpdateEventRegistrationCount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateEventRegistrationCountListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventRegistrationUpdated $event): void
    {
        UpdateEventRegistrationCount::dispatch($event->event);
    }
}
