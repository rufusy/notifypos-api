<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['M', 'F']);

        if($gender === 'M') {
            $firstName = $this->faker->firstNameMale;
            $lastName = $this->faker->firstNameMale;
        } else {
            $firstName = $this->faker->firstNameFemale;
            $lastName = $this->faker->firstNameFemale;
        }

        return [
            'last_name' => $lastName,
            'first_name' => $firstName,
            'gender'  => $gender,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'country' => $this->faker->country,
            'address' => $this->faker->address,
            'city' => $this->faker->city
        ];
    }
}
