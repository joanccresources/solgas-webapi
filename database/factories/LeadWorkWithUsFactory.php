<?php

namespace Database\Factories;

use App\Models\Employment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeadWorkWithUs>
 */
class LeadWorkWithUsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cv_path' => $this->faker->filePath(),
            'full_name' => $this->faker->name(),
            'dni' => $this->faker->unique()->numerify('########'),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'birth_date' => $this->faker->date(),
            'employment_id' => Employment::query()->inRandomOrder()->value('id'),
        ];
    }
}
