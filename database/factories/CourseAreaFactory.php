<?php

namespace Database\Factories;

use App\Models\CourseArea;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CourseArea>
 */
class CourseAreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = fake()->unique()->words(3, true),
            'slug' => Str::slug($title),
            'icon' => fake()->randomElement(CourseArea::ICONS),
            'summary' => fake()->sentence(),
            'items' => fake()->words(4),
            'show_on_home' => true,
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
