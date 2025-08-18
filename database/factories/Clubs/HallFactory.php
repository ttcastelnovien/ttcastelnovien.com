<?php

namespace Database\Factories\Clubs;

use App\Models\Communication\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Group>
 */
class HallFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address_line_1' => $this->faker->streetAddress(),
            'address_line_2' => $this->faker->streetName(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
