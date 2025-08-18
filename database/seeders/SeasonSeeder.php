<?php

namespace Database\Seeders;

use App\Models\Meta\Season;
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
                'name' => '2025/2026',
                'starts_at' => Carbon::create(year: 2025, month: 7),
                'ends_at' => Carbon::create(year: 2026, month: 6, day: 30),
            ],
            [
                'name' => '2026/2027',
                'starts_at' => Carbon::create(year: 2026, month: 7),
                'ends_at' => Carbon::create(year: 2027, month: 6, day: 30),
            ],
            [
                'name' => '2027/2028',
                'starts_at' => Carbon::create(year: 2027, month: 7),
                'ends_at' => Carbon::create(year: 2028, month: 6, day: 30),
            ],
            [
                'name' => '2028/2029',
                'starts_at' => Carbon::create(year: 2028, month: 7),
                'ends_at' => Carbon::create(year: 2029, month: 6, day: 30),
            ],
            [
                'name' => '2029/2030',
                'starts_at' => Carbon::create(year: 2029, month: 7),
                'ends_at' => Carbon::create(year: 2030, month: 6, day: 30),
            ],
            [
                'name' => '2030/2031',
                'starts_at' => Carbon::create(year: 2030, month: 7),
                'ends_at' => Carbon::create(year: 2031, month: 6, day: 30),
            ],
        ]);
    }
}
