<?php

namespace Database\Factories\Meta;

use App\Models\Meta\Season;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Season>
 */
class SeasonFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        $year = (int) $this->faker->year();

        return [
            'name' => sprintf('%s/%s', $year, $year + 1),
            'starts_at' => Carbon::create(year: $year, month: 7),
            'ends_at' => Carbon::create(year: $year + 1, month: 6, day: 30),
        ];
    }
}
