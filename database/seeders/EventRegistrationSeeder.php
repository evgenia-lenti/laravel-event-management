<?php

namespace Database\Seeders;

use App\Jobs\UpdateEventRegistrationCount;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // registers up to 5 random users to each event
        Event::all()->each(function ($event) use ($users) {
            $event->registrations()->syncWithoutDetaching(
                $users->random(rand(0, 5))->pluck('id')
            );

            // update the event registration count
            UpdateEventRegistrationCount::dispatch($event);
        });
    }
}
