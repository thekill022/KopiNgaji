<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Umkm>
 */
class UmkmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->paragraph(),
            'owner_id' => \App\Models\User::factory(),
            'platform_fee' => fake()->randomFloat(2, 1000, 10000),
            'revenue_total' => fake()->randomFloat(2, 100000, 10000000),
        ];
    }
}
