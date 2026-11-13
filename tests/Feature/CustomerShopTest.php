<?php

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_active_shops(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        Shop::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.shops.index'));

        $response->assertOk();
    }

    public function test_inactive_shops_are_not_displayed(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $activeShop = Shop::factory()->create([
            'name' => 'Toko Aktif',
            'is_active' => true,
        ]);

        $inactiveShop = Shop::factory()->create([
            'name' => 'Toko Tidak Aktif',
            'is_active' => false,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.shops.index'));

        $response->assertOk()
            ->assertSee('Toko Aktif')
            ->assertDontSee('Toko Tidak Aktif');
    }

    public function test_customer_can_search_shops_by_name(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        Shop::factory()->create([
            'name' => 'Printar Mataram',
            'is_active' => true,
        ]);

        Shop::factory()->create([
            'name' => 'Digital Printing Lombok',
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.shops.index', [
                'search' => 'Printar',
            ]));

        $response->assertOk()
            ->assertSee('Printar Mataram')
            ->assertDontSee('Digital Printing Lombok');
    }

    public function test_customer_can_search_shops_by_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        Shop::factory()->create([
            'name' => 'Toko A',
            'address' => 'Jalan Pejanggik Mataram',
            'is_active' => true,
        ]);

        Shop::factory()->create([
            'name' => 'Toko B',
            'address' => 'Jalan Sudirman Jakarta',
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.shops.index', [
                'search' => 'Pejanggik',
            ]));

        $response->assertOk()
            ->assertSee('Toko A')
            ->assertDontSee('Toko B');
    }

    public function test_customer_can_view_shop_detail(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $shop = Shop::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.shops.show', $shop->id));

        $response->assertOk();
    }

    public function test_customer_cannot_view_inactive_shop_detail(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $shop = Shop::factory()->create([
            'is_active' => false,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.shops.show', $shop->id));

        $response->assertNotFound();
    }

    public function test_customer_cannot_view_nonexistent_shop_detail(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.shops.show', 99999));

        $response->assertNotFound();
    }

    public function test_guest_cannot_view_shop_list(): void
    {
        $response = $this->get(route('customer.shops.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_view_shop_detail(): void
    {
        $shop = Shop::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->get(
            route('customer.shops.show', $shop->id)
        );

        $response->assertRedirect(route('login'));
    }
}
