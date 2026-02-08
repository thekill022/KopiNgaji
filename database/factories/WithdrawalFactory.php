<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdrawal>
 */
class WithdrawalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => \App\Models\User::factory(),
            'amount' => fake()->randomFloat(2, 100000, 5000000),
            'bank_name' => fake()->name(), // Faker doesn't have bank name, sticking with name or creditCardType? 'name' is safer as placeholder.
            'bank_account' => fake()->bankAccountNumber(),
            'status' => fake()->randomElement(['PENDING', 'APPROVED', 'REJECTED']),
        ];
    }
}
