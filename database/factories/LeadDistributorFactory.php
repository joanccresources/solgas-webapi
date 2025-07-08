<?php

namespace Database\Factories;

use App\Models\MasterUbigeo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeadDistributor>
 */
class LeadDistributorFactory extends Factory
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
            'dni_or_ruc' => $this->faker->numerify('###########'),
            'phone_1' => $this->faker->phoneNumber(),
            'phone_2' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'code_ubigeo' => MasterUbigeo::query()->inRandomOrder()->value('code_ubigeo'),
            'has_store' => $this->faker->boolean(),
            'sells_gas_cylinders' => $this->faker->boolean(),
            'brands_sold' => $this->faker->words(3, true),
            'selling_time' => $this->faker->numberBetween(1, 20) . ' years',
            'monthly_sales' => $this->faker->numberBetween(50, 500),
            'accepts_data_policy' => $this->faker->boolean(),
        ];
    }
}
