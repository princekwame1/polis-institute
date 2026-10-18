<?php

namespace Database\Factories;

use App\Models\Facilitator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Facilitator>
 */
class FacilitatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement(['Facilitator', 'Programme Coordinator', 'Director']),
            'bio' => fake()->paragraph(),
            'photo' => null,
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
