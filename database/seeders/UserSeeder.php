<?php

namespace Database\Seeders;

use App\Enums\Sex;
use App\Enums\UserRole;
use App\Models\HumanResource\Person;
use App\Models\Security\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $person = Person::factory()->create([
            'first_name' => 'Aurélien',
            'last_name' => 'Devaux',
            'sex' => Sex::Homme,
            'licence_number' => '1610533',
            'birth_date' => '1998-09-22',
            'birth_city' => "L'Isle d'Espagnac",
            'email' => 'fftt@aureldvx.net',
            'phone' => '0600000000',
            'address_line_1' => '165 Rue de la Croix Nouvelle',
            'postal_code' => '16120',
            'city' => 'Châteauneuf-sur-Charente',
        ]);

        User::factory()->create([
            'username' => 'aurelien.devaux',
            'roles' => [UserRole::ADMIN, UserRole::HISTORY],
            'person_id' => $person->id,
        ]);
    }
}
