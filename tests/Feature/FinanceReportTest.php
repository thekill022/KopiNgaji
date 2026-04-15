<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Umkm;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\Withdrawal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceReportTest extends TestCase
{
    use RefreshDatabase;

    private function createVerifiedOwner(): User
    {
        $user = User::factory()->create(['role' => 'OWNER', 'email_verified_at' => now()]);
        Umkm::factory()->create(['owner_id' => $user->id, 'is_verified' => true]);
        return $user;
    }

    public function test_owner_can_view_finance_report()
    {
        $seller = $this->createVerifiedOwner();
        $buyer = User::factory()->create(['role' => 'BUYER']);
        $product = Product::factory()->create([
            'umkm_id' => $seller->umkm->id,
            'cost_price' => 20000,
        ]);

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'umkm_id' => $seller->umkm->id,
            'status' => 'COMPLETED',
            'payment_method' => 'NON_CASH',
            'net_amount' => 100000,
            'created_at' => now(),
        ]);
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 50000,
        ]);

        Withdrawal::factory()->create([
            'owner_id' => $seller->id,
            'gross_amount' => 30000,
            'status' => 'APPROVED',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($seller)
            ->get(route('seller.finance.index'));

        $response->assertStatus(200)
            ->assertSee('Rp 100.000')
            ->assertSee('Rp 40.000') // COGS = 2 * 20000
            ->assertSee('Rp 30.000') // withdrawals
            ->assertSee('Rp 60.000') // net profit = 100k - 40k
            ->assertSee('Rp 70.000'); // available balance = 100k - 30k
    }

    public function test_finance_report_respects_date_filter()
    {
        $seller = $this->createVerifiedOwner();
        $buyer = User::factory()->create(['role' => 'BUYER']);

        // Old order (outside filter)
        Order::factory()->create([
            'buyer_id' => $buyer->id,
            'umkm_id' => $seller->umkm->id,
            'status' => 'COMPLETED',
            'payment_method' => 'NON_CASH',
            'net_amount' => 50000,
            'created_at' => now()->subDays(60),
        ]);

        // Recent order (inside filter)
        Order::factory()->create([
            'buyer_id' => $buyer->id,
            'umkm_id' => $seller->umkm->id,
            'status' => 'COMPLETED',
            'payment_method' => 'NON_CASH',
            'net_amount' => 75000,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($seller)
            ->get(route('seller.finance.index', [
                'start_date' => now()->subDays(7)->format('Y-m-d'),
                'end_date' => now()->format('Y-m-d'),
            ]));

        $response->assertStatus(200)
            ->assertSee('Rp 75.000')
            ->assertDontSee('Rp 50.000');
    }
}
