<?php

namespace Database\Factories;

use App\Models\Employment;
use App\Models\EmploymentSimilar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmploymentSimilar>
 */
class EmploymentSimilarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = EmploymentSimilar::class;

    public function definition(): array
    {
        return [
            'employment_id' => Employment::factory(),
            'employment_similar_id' => Employment::factory(),
        ];
    }
}
