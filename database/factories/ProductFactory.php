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
            'umkm_id' => \App\Models\Umkm::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10000, 500000),
            'cost_price' => fake()->randomFloat(2, 5000, 400000),
            'discount' => fake()->randomFloat(2, 0, 50000),
            'stock' => fake()->numberBetween(0, 100),
            'image_url' => 'products/placeholder_' . fake()->numberBetween(1, 8) . '.svg',
            'is_preorder' => fake()->boolean(),
            'status' => fake()->randomElement(['PENDING', 'APPROVED', 'REJECTED']),
        ];
    }
}
