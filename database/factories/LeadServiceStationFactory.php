<?php

namespace Database\Factories;

use App\Models\MasterUbigeo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeadServiceStation>
 */
class LeadServiceStationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'ruc' => $this->faker->numerify('###########'),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'region' => $this->faker->words(3, true),
            'message' => $this->faker->sentence(),
        ];
    }
}
