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
        $feeType = fake()->randomElement(['percentage', 'flat']);

        return [
            'name' => fake()->company(),
            'description' => fake()->paragraph(),
            'owner_id' => \App\Models\User::factory(),
            'platform_fee_type' => $feeType,
            'platform_fee_rate' => $feeType === 'percentage' ? fake()->randomFloat(2, 1, 15) : 0,
            'platform_fee_flat' => $feeType === 'flat' ? fake()->randomFloat(2, 1000, 10000) : 0,
            'is_verified' => fake()->boolean(50),
        ];
    }
}
