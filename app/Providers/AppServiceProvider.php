<?php

namespace App\Providers;

use App\Events\EventRegistrationUpdated;
use App\Listeners\UpdateEventRegistrationCountListener;
use App\Models\EventRegistration;
use App\Observers\EventRegistrationObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // Register the observer
        EventRegistration::observe(EventRegistrationObserver::class);

        // Register event listener
        Event::listen(
            EventRegistrationUpdated::class,
            [UpdateEventRegistrationCountListener::class, 'handle']
        );
    }
}
