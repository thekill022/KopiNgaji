<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'ADMIN',
        ]);

        // Create Owner with Umkm and Products
        $owner = User::factory()->create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'role' => 'OWNER',
        ]);

        $umkm = \App\Models\Umkm::factory()->create([
            'owner_id' => $owner->id,
        ]);

        $products = \App\Models\Product::factory(5)->create([
            'umkm_id' => $umkm->id,
        ]);

        // Create Buyer with Orders
        $buyer = User::factory()->create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'role' => 'BUYER',
        ]);

        $order = \App\Models\Order::factory()->create([
            'buyer_id' => $buyer->id,
            'umkm_id' => $umkm->id,
        ]);

        \App\Models\OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $products->first()->id,
        ]);

        \App\Models\Payment::factory()->create([
            'order_id' => $order->id,
        ]);

        \App\Models\Withdrawal::factory()->create([
            'owner_id' => $owner->id,
        ]);
    }
}
