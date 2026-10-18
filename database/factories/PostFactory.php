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
        return [
            'title' => $title = fake()->unique()->sentence(6),
            'slug' => Str::slug($title),
            'category' => fake()->randomElement(Post::categories()),
            'excerpt' => fake()->sentence(20),
            'body' => implode("\n\n", fake()->paragraphs(4)),
            'image' => null,
            'published_at' => now()->subDay(),
        ];
    }

    /**
     * Indicate that the post is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (): array => ['published_at' => null]);
    }
}
