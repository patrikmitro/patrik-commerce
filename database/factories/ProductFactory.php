<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'description' => fake()->text(1000),
            'short_description' => fake()->text(250),
            'price' => fake()->randomFloat(2, 5, 100),
            'old_price' => null,
            'quantity' => fake()->numberBetween(0 , 10)
        ];
    }

    public function onSale(): static
    {
        return $this->state(fn (array $attributes) => [
            'old_price' => fake()->randomFloat(2, $attributes['price'], 101),
        ]);
    }
}
