<?php

namespace Database\Factories;

use App\Models\TagPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagPost>
 */
class TagPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = TagPost::class;

    public function definition(): array
    {
        return [
            'post_id' => \App\Models\Post::factory(),
            'tag_id' => \App\Models\Tag::factory(),
        ];
    }
}
