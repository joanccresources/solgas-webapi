<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostSimilar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostSimilar>
 */
class PostSimilarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PostSimilar::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'post_similar_id' => Post::factory()
        ];
    }
}
