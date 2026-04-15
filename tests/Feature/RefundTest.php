<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Umkm;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RefundTest extends TestCase
{
    use RefreshDatabase;

    private function createVerifiedOwner(): User
    {
        $user = User::factory()->create(['role' => 'OWNER', 'email_verified_at' => now()]);
        Umkm::factory()->create(['owner_id' => $user->id, 'is_verified' => true]);
        return $user;
    }

    public function test_seller_can_refund_cash_order_immediately()
    {
        $seller = $this->createVerifiedOwner();
        $buyer = User::factory()->create(['role' => 'BUYER']);
        $product = Product::factory()->create([
            'umkm_id' => $seller->umkm->id,
            'status' => 'APPROVED',
            'stock' => 10,
        ]);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'umkm_id' => $seller->umkm->id,
            'status' => 'COMPLETED',
            'payment_method' => 'CASH',
            'net_amount' => 50000,
        ]);
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 25000,
        ]);

        $response = $this->actingAs($seller)->post(route('seller.orders.refund', $order), [
            'amount' => 50000,
            'reason' => 'Barang rusak',
        ]);

        $response->assertRedirect(route('seller.orders.show', $order));
        $this->assertDatabaseHas('refunds', [
            'order_id' => $order->id,
            'amount' => 50000,
            'status' => 'APPROVED',
        ]);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'REFUNDED',
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 12, // restored
        ]);
    }

    public function test_seller_can_request_refund_for_non_cash_order()
    {
        $seller = $this->createVerifiedOwner();
        $buyer = User::factory()->create(['role' => 'BUYER']);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'umkm_id' => $seller->umkm->id,
            'status' => 'PAID',
            'payment_method' => 'NON_CASH',
            'net_amount' => 100000,
        ]);

        $response = $this->actingAs($seller)->post(route('seller.orders.refund', $order), [
            'amount' => 50000,
            'reason' => 'Permintaan buyer',
        ]);

        $response->assertRedirect(route('seller.orders.show', $order));
        $this->assertDatabaseHas('refunds', [
            'order_id' => $order->id,
            'amount' => 50000,
            'status' => 'PENDING',
        ]);
        // Order status should remain PAID until admin approves refund manually
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'PAID',
        ]);
    }

    public function test_seller_cannot_refund_pending_order()
    {
        $seller = $this->createVerifiedOwner();
        $buyer = User::factory()->create(['role' => 'BUYER']);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'umkm_id' => $seller->umkm->id,
            'status' => 'PENDING',
            'payment_method' => 'CASH',
            'net_amount' => 50000,
        ]);

        $response = $this->actingAs($seller)->post(route('seller.orders.refund', $order), [
            'amount' => 50000,
            'reason' => 'Test',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('refunds', ['order_id' => $order->id]);
    }
}
