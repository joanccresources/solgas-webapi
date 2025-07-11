<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Tag::class;

    public function definition(): array
    {
        $name = $this->faker->sentence();

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . uniqid()),
            'active' => true,
        ];
    }
}
