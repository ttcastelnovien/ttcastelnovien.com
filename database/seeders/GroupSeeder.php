<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Group::factory()->createMany([
            ['name' => "Conseil d'administration"],
            ['name' => 'Licenciés'],
            ['name' => 'Commission Technique'],
            ['name' => 'Vétérans'],
            ['name' => 'Jeunes'],
            ['name' => 'Championnat par équipes'],
            ['name' => 'Critérium Fédéral'],
            ['name' => 'Championnat Jeunes'],
        ]);
    }
}
