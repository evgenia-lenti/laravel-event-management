<?php

namespace Database\Factories;

use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'event_date' => $this->faker->dateTimeBetween('+1 days', '+3 months'),
            'location' => $this->faker->city(),
            'capacity' => $this->faker->numberBetween(10, 1000),
            'current_registrations_count' => 0,
            'status' => $this->faker->randomElement([
                EventStatus::Draft,
                EventStatus::Published,
                EventStatus::Cancelled,
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
