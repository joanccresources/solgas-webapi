<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeadEmailDestination>
 */
class LeadEmailDestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(), // Genera un nombre ficticio
            'email' => $this->faker->unique()->safeEmail(), // Genera un correo electrónico único
        ];
    }
}
