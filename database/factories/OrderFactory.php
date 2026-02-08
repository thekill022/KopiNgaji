<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'buyer_id' => \App\Models\User::factory(),
            'umkm_id' => \App\Models\Umkm::factory(),
            'status' => fake()->randomElement(['PENDING', 'PAID', 'CANCELLED', 'COMPLETED']),
            'payment_method' => fake()->randomElement(['CASH', 'NON_CASH']),
            'total_price' => fake()->randomFloat(2, 50000, 1000000),
            'whatsapp' => fake()->phoneNumber(),
            'qr_code' => fake()->uuid(),
            'is_scanned' => fake()->boolean(),
        ];
    }
}
