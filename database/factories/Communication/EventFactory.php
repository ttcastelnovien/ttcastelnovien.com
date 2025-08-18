<?php

namespace Database\Factories\Communication;

use App\Models\Communication\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', '+1 year');

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'at_home' => $this->faker->boolean(),
            'start_date' => $startDate,
            'start_time' => $this->faker->time(),
            'end_date' => $startDate->add(new \DateInterval('P1D')),
            'end_time' => $this->faker->time(),
            'opponent' => $this->faker->company(),
            'check_in_time' => $this->faker->time(),
            'departure_time' => $this->faker->time(),
        ];
    }
}
