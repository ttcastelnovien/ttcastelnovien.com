<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SeasonSeeder::class,
            UserSeeder::class,
            GroupSeeder::class,
            ClubSeeder::class,
        ]);
    }
}
