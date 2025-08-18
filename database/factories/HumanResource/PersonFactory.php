<?php

namespace Database\Factories\HumanResource;

use App\Enums\Sex;
use App\Models\HumanResource\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'sex' => Sex::from($this->faker->randomElement(['H', 'F'])),
            'birth_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date(),
            'birth_city' => $this->faker->city(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address_line_1' => $this->faker->streetAddress(),
            'address_line_2' => $this->faker->streetName(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'licence_number' => $this->faker->unique()->numerify('######'),
            'nationality' => 'FR',
            'father_name' => $this->faker->name(),
            'mother_name' => $this->faker->name(),
        ];
    }
}
