<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'is_published' => fake()->boolean(),
            'published_at' => fake()->optional()->dateTimeBetween('-1 month'),
        ];
    }
}
