<?php

namespace Database\Seeders;

use App\Models\Communication\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
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
