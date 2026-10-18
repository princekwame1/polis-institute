<?php

namespace Database\Factories;

use App\Models\Enquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'contact',
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'subject' => fake()->sentence(4),
            'message' => fake()->paragraph(),
        ];
    }

    /**
     * Indicate that the enquiry is a course registration.
     */
    public function registration(): static
    {
        return $this->state(fn (): array => [
            'type' => 'registration',
            'course' => fake()->randomElement(['Digital Marketing', 'Brand Strategy', 'Public Speaking']),
            'learning_mode' => fake()->randomElement(['online', 'in-person']),
            'location' => fake()->randomElement(['Accra', 'Sunyani']),
        ]);
    }

    /**
     * Indicate that the enquiry has been dealt with.
     */
    public function handled(): static
    {
        return $this->state(fn (): array => ['handled_at' => now()]);
    }

    /**
     * Indicate that the enquiry is a corporate training request.
     */
    public function corporate(): static
    {
        return $this->state(fn (): array => [
            'type' => 'corporate',
            'organisation' => fake()->company(),
            'course' => fake()->randomElement(config('prolis.corporate_areas')),
        ]);
    }
}
