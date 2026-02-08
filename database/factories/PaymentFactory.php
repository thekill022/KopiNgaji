<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::factory(),
            'provider' => fake()->creditCardType(),
            'reference_id' => fake()->uuid(),
            'amount' => fake()->randomFloat(2, 50000, 1000000),
            'paid_at' => fake()->dateTime(),
        ];
    }
}
