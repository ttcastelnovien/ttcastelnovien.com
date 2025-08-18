<?php

namespace Database\Factories\Communication;

use App\Models\Communication\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Group>
 */
class GroupFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainWord(),
            'color' => $this->faker->hexColor(),
        ];
    }
}
