<?php

namespace Database\Factories\Security;

use App\Enums\UserRole;
use App\Models\Security\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
            'roles' => $this->faker->randomElement([
                [UserRole::USER],
                [UserRole::ADMIN],
                [UserRole::ADMIN, UserRole::HISTORY],
            ]),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
