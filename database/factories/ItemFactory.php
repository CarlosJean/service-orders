<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
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
            'price' => fake()->randomDigit(),
            'quantity' => fake()->randomDigit(),
            'reference' => fake()->sentence(),
            'measurement_unit' => fake()->sentence(1),
            'description' => fake()->sentence(1),
            'id_category' => fake()->numberBetween(1,3),
        ];
    }
}
