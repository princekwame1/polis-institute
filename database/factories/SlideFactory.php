<?php

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slide>
 */
class SlideFactory extends Factory
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
            'text' => fake()->sentence(15),
            'image' => null,
            'image_alt' => fake()->sentence(5),
            'primary_button_text' => 'Explore Courses',
            'primary_button_url' => '/courses-and-programmes',
            'secondary_button_text' => 'Contact Us',
            'secondary_button_url' => '/contact-us',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
