<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title  . '-' . uniqid()),
            'short_description' => $this->faker->paragraph(),
            'content' => $this->faker->text(500),
            'image' => '',
            'thumbnail' => '',
            'active' => true,
            'view' => $this->faker->randomNumber(),
            'like' => $this->faker->randomNumber(),
            'shared' => $this->faker->randomNumber(),
            'publication_at' => now(),
            'user_id' => User::query()->inRandomOrder()->value('id'),
        ];
    }
}
