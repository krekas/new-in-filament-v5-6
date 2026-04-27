<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);
        $status = fake()->randomElement(['draft', 'published']);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title),
            'content' => fake()->paragraphs(4, true),
            'status' => $status,
            'views' => fake()->numberBetween(0, 5000),
            'published_at' => $status === 'published' ? fake()->dateTimeBetween('-2 months', 'now') : null,
        ];
    }
}
