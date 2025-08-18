<?php

namespace Database\Factories\Clubs;

use App\Models\Communication\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Group>
 */
class ClubFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainWord(),
            'short_name' => $this->faker->word(),
        ];
    }
}
