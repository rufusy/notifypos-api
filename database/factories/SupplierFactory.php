<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['I', 'B']);
        $companyName = $type === 'I' ? '' : $this->faker->company;

        return [
            'person_id' => Person::factory()->create()->id,
            'company_name' => $companyName,
            'type' => $type
        ];
    }
}
