<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Umkm;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DualRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_access_buyer_routes()
    {
        $owner = User::factory()->create(['role' => 'OWNER', 'email_verified_at' => now()]);
        $umkm = Umkm::factory()->create(['is_verified' => true]);
        $product = Product::factory()->create([
            'umkm_id' => $umkm->id,
            'status' => 'APPROVED',
            'is_active' => true,
        ]);

        $this->actingAs($owner)
            ->get(route('dashboard'))
            ->assertRedirect(route('umkms.index'));

        $this->actingAs($owner)
            ->get(route('umkms.index'))
            ->assertStatus(200);

        $this->actingAs($owner)
            ->get(route('products.show', $product))
            ->assertStatus(200);

        $this->actingAs($owner)
            ->get(route('cart.index'))
            ->assertStatus(200);
    }

    public function test_buyer_cannot_access_seller_routes()
    {
        $buyer = User::factory()->create(['role' => 'BUYER', 'email_verified_at' => now()]);

        $this->actingAs($buyer)
            ->get(route('seller.dashboard'))
            ->assertStatus(403);
    }

    public function test_owner_can_switch_to_buyer_mode_via_navigation()
    {
        $owner = User::factory()->create(['role' => 'OWNER', 'email_verified_at' => now()]);
        Umkm::factory()->create(['owner_id' => $owner->id, 'is_verified' => true]);

        $response = $this->actingAs($owner)
            ->get(route('seller.dashboard'));

        $response->assertStatus(200)
            ->assertSee('Mode Pembeli');
    }
}
