<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employment;
use App\Models\EmploymentType;
use App\Models\EmploymentArea;
use App\Models\MasterUbigeo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employment>
 */
class EmploymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraphs(3, true),
            'address' => $this->faker->address,
            'code_ubigeo' => MasterUbigeo::query()->inRandomOrder()->value('code_ubigeo'),
            'posted_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'employment_type_id' => EmploymentType::query()->inRandomOrder()->value('id'),
            'employment_area_id' => EmploymentArea::query()->inRandomOrder()->value('id')
        ];
    }
}
