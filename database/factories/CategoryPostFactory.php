<?php

namespace Database\Factories;

use App\Models\CategoryPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoryPost>
 */
class CategoryPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = CategoryPost::class;

    public function definition(): array
    {
        return [
            'post_id' => \App\Models\Post::factory(),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
