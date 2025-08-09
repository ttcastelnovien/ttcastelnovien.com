<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SeasonSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Season::factory()->createMany([
            [
                'starts_at' => Carbon::create(year: 2025, month: 7),
                'ends_at' => Carbon::create(year: 2026, month: 6, day: 30),
            ],
            [
                'starts_at' => Carbon::create(year: 2026, month: 7),
                'ends_at' => Carbon::create(year: 2027, month: 6, day: 30),
            ],
            [
                'starts_at' => Carbon::create(year: 2027, month: 7),
                'ends_at' => Carbon::create(year: 2028, month: 6, day: 30),
            ],
            [
                'starts_at' => Carbon::create(year: 2028, month: 7),
                'ends_at' => Carbon::create(year: 2029, month: 6, day: 30),
            ],
            [
                'starts_at' => Carbon::create(year: 2029, month: 7),
                'ends_at' => Carbon::create(year: 2030, month: 6, day: 30),
            ],
            [
                'starts_at' => Carbon::create(year: 2030, month: 7),
                'ends_at' => Carbon::create(year: 2031, month: 6, day: 30),
            ],
        ]);
    }
}
