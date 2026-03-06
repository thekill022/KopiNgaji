<?php

namespace Tests\Feature;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerUmkmTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_register_umkm()
    {
        $user = User::factory()->create(['role' => 'OWNER']);

        $this->actingAs($user)
            ->get(route('seller.umkm.create'))
            ->assertStatus(200);

        // dashboard should contain link prompting to register
        $this->actingAs($user)
            ->get(route('seller.dashboard'))
            ->assertSee('Daftar UMKM');

        $response = $this->actingAs($user)->post(route('seller.umkm.store'), [
            'name' => 'Toko Test',
            'description' => 'Deskripsi',
        ]);

        $response->assertRedirect(route('seller.dashboard'));
        $this->assertDatabaseHas('umkms', [
            'owner_id' => $user->id,
            'name' => 'Toko Test',
        ]);
    }

    public function test_owner_cannot_access_create_if_has_umkm()
    {
        $user = User::factory()->create(['role' => 'OWNER']);
        Umkm::factory()->create(['owner_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('seller.umkm.create'))
            ->assertRedirect(route('seller.dashboard'));
    }

    public function test_getUmkm_aborts_if_not_verified()
    {
        $user = User::factory()->create(['role' => 'OWNER']);
        $umkm = Umkm::factory()->create(['owner_id' => $user->id, 'is_verified' => false]);

        $this->actingAs($user)
            ->get(route('seller.products.index'))
            ->assertStatus(403);
    }

    public function test_buyer_sees_only_verified_umkms()
    {
        $buyer = User::factory()->create(['role' => 'BUYER']);
        $visible = Umkm::factory()->create(['is_verified' => true, 'name' => 'A']);
        $hidden = Umkm::factory()->create(['is_verified' => false, 'name' => 'B']);

        $response = $this->actingAs($buyer)->get(route('umkms.index'));
        $response->assertSee('A');
        $response->assertDontSee('B');

        // detail page of verified umkm should be accessible
        $response = $this->actingAs($buyer)->get(route('umkms.show', $visible));
        $response->assertStatus(200)->assertSee('A');

        // detail page of unverified should return 404
        $this->actingAs($buyer)
            ->get(route('umkms.show', $hidden))
            ->assertStatus(404);
    }

    public function test_dashboard_redirects_to_umkms_list()
    {
        $buyer = User::factory()->create(['role' => 'BUYER']);

        $response = $this->actingAs($buyer)->get(route('dashboard'));
        $response->assertRedirect(route('umkms.index'));

        // follow the redirect and ensure index view is shown
        $follow = $this->actingAs($buyer)->followingRedirects()->get(route('dashboard'));
        $follow->assertStatus(200)->assertViewIs('umkms.index');
    }

    public function test_search_umkm_by_product_name()
    {
        $buyer = User::factory()->create(['role' => 'BUYER']);
        $umkmWithProduct = Umkm::factory()->create(['is_verified' => true, 'name' => 'StoreX']);
        $umkmWithProduct->products()->create(["name" => "Special Coffee", "price" => 10000]);
        Umkm::factory()->create(['is_verified' => true, 'name' => 'Other']);

        $response = $this->actingAs($buyer)->get(route('umkms.index', ['search' => 'Special']));
        $response->assertSee('StoreX');
        $response->assertSee('Special Coffee');
        $response->assertDontSee('Other');
    }

    public function test_search_products_within_umkm_show()
    {
        $buyer = User::factory()->create(['role' => 'BUYER']);
        $umkm = Umkm::factory()->create(['is_verified' => true]);
        $umkm->products()->create(["name" => "Latte", "price" => 12000]);
        $umkm->products()->create(["name" => "Espresso", "price" => 8000]);

        $response = $this->actingAs($buyer)->get(route('umkms.show', ['umkm' => $umkm, 'search' => 'Latte']));
        $response->assertSee('Latte');
        $response->assertDontSee('Espresso');
    }
}
