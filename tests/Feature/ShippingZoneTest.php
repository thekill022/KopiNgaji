<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingZoneTest extends TestCase
{
    use RefreshDatabase;

    private function createVerifiedOwner(): User
    {
        $user = User::factory()->create(['role' => 'OWNER', 'email_verified_at' => now()]);
        Umkm::factory()->create(['owner_id' => $user->id, 'is_verified' => true]);
        return $user;
    }

    public function test_owner_can_create_shipping_zone()
    {
        $user = $this->createVerifiedOwner();

        $response = $this->actingAs($user)->post(route('seller.shipping-zones.store'), [
            'name' => 'Zona Malang',
            'cost' => 15000,
            'areas' => ['Kecamatan Klojen', 'Kecamatan Blimbing'],
        ]);

        $response->assertRedirect(route('seller.shipping-zones.index'));
        $this->assertDatabaseHas('shipping_zones', ['name' => 'Zona Malang', 'cost' => 15000]);
        $this->assertDatabaseHas('shipping_zone_areas', ['area_name' => 'Kecamatan Klojen']);
        $this->assertDatabaseHas('shipping_zone_areas', ['area_name' => 'Kecamatan Blimbing']);
    }

    public function test_owner_can_update_shipping_zone()
    {
        $user = $this->createVerifiedOwner();
        $zone = $user->umkm->shippingZones()->create(['name' => 'Old Zone', 'cost' => 5000]);
        $zone->areas()->create(['area_name' => 'Old Area']);

        $response = $this->actingAs($user)->put(route('seller.shipping-zones.update', $zone), [
            'name' => 'Updated Zone',
            'cost' => 10000,
            'areas' => ['New Area 1', 'New Area 2'],
        ]);

        $response->assertRedirect(route('seller.shipping-zones.index'));
        $this->assertDatabaseHas('shipping_zones', ['id' => $zone->id, 'name' => 'Updated Zone']);
        $this->assertDatabaseMissing('shipping_zone_areas', ['area_name' => 'Old Area']);
        $this->assertDatabaseHas('shipping_zone_areas', ['area_name' => 'New Area 1']);
    }

    public function test_owner_can_delete_shipping_zone()
    {
        $user = $this->createVerifiedOwner();
        $zone = $user->umkm->shippingZones()->create(['name' => 'Delete Me', 'cost' => 5000]);
        $zone->areas()->create(['area_name' => 'Area']);

        $response = $this->actingAs($user)->delete(route('seller.shipping-zones.destroy', $zone));

        $response->assertRedirect(route('seller.shipping-zones.index'));
        $this->assertDatabaseMissing('shipping_zones', ['id' => $zone->id]);
        $this->assertDatabaseMissing('shipping_zone_areas', ['shipping_zone_id' => $zone->id]);
    }

    public function test_shipping_zone_appears_in_checkout()
    {
        $seller = $this->createVerifiedOwner();
        $buyer = User::factory()->create(['role' => 'BUYER', 'email_verified_at' => now()]);
        $product = \App\Models\Product::factory()->create([
            'umkm_id' => $seller->umkm->id,
            'status' => 'APPROVED',
            'is_active' => true,
            'stock' => 10,
        ]);

        $zone = $seller->umkm->shippingZones()->create(['name' => 'Zona Test', 'cost' => 12000]);
        $zone->areas()->create(['area_name' => 'Area A']);

        // Add to cart
        $this->actingAs($buyer)->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($buyer)->get(route('checkout.index'));
        $response->assertStatus(200)
            ->assertSee('Zona Test')
            ->assertSee('Rp 12.000');
    }
}
