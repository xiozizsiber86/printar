<?php

namespace Tests\Feature;

use App\Models\MerchantProfile;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchantShopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Merchant berhasil melihat daftar tokonya.
     */
    public function test_merchant_can_view_own_shops(): void
    {
        $profile = MerchantProfile::factory()->create();

        Shop::factory()->create([
            'merchant_id' => $profile->id,
            'name' => 'Toko Printar',
        ]);

        $response = $this->actingAs($profile->user)
            ->get(route('merchant.shops.index'));

        $response->assertOk()
            ->assertViewHas('shops');

        $response->assertSee('Toko Printar');
    }

    /**
     * Merchant berhasil membuka formulir tambah toko.
     */
    public function test_merchant_can_view_create_shop_form(): void
    {
        $profile = MerchantProfile::factory()->create();

        $response = $this->actingAs($profile->user)
            ->get(route('merchant.shops.create'));

        $response->assertOk();
    }

    /**
     * Merchant berhasil menambahkan toko.
     */
    public function test_merchant_can_create_shop(): void
    {
        $profile = MerchantProfile::factory()->create();

        $response = $this->actingAs($profile->user)
            ->post(route('merchant.shops.store'), [
                'name' => 'Printar Digital Printing',
                'description' => 'Layanan percetakan digital.',
                'address' => 'Mataram, Nusa Tenggara Barat',
                'phone' => '081234567890',
                'latitude' => -8.5833000,
                'longitude' => 116.1160000,
            ]);

        $response->assertRedirect(route('merchant.shops.index'));

        $this->assertDatabaseHas('shops', [
            'merchant_id' => $profile->id,
            'name' => 'Printar Digital Printing',
            'address' => 'Mataram, Nusa Tenggara Barat',
        ]);
    }

    /**
     * Toko baru otomatis berstatus tidak aktif.
     */
    public function test_new_shop_is_inactive_by_default(): void
    {
        $profile = MerchantProfile::factory()->create();

        $this->actingAs($profile->user)
            ->post(route('merchant.shops.store'), [
                'name' => 'Toko Baru',
                'description' => 'Toko percetakan baru.',
                'address' => 'Mataram',
                'phone' => '081234567890',
            ]);

        $this->assertDatabaseHas('shops', [
            'merchant_id' => $profile->id,
            'name' => 'Toko Baru',
            'is_active' => false,
        ]);
    }

    /**
     * Nama toko wajib diisi.
     */
    public function test_shop_name_is_required(): void
    {
        $profile = MerchantProfile::factory()->create();

        $this->actingAs($profile->user)
            ->post(route('merchant.shops.store'), [
                'name' => '',
                'description' => 'Toko percetakan.',
                'address' => 'Mataram',
                'phone' => '081234567890',
            ])
            ->assertSessionHasErrors('name');
    }

    /**
     * Merchant berhasil membuka formulir edit toko.
     */
    public function test_merchant_can_view_edit_shop_form(): void
    {
        $profile = MerchantProfile::factory()->create();

        $shop = Shop::factory()->create([
            'merchant_id' => $profile->id,
        ]);

        $response = $this->actingAs($profile->user)
            ->get(route('merchant.shops.edit', $shop->id));

        $response->assertOk()
            ->assertViewHas('shop');
    }

    /**
     * Merchant berhasil mengubah data toko.
     */
    public function test_merchant_can_update_own_shop(): void
    {
        $profile = MerchantProfile::factory()->create();

        $shop = Shop::factory()->create([
            'merchant_id' => $profile->id,
            'name' => 'Nama Lama',
        ]);

        $response = $this->actingAs($profile->user)
            ->put(route('merchant.shops.update', $shop->id), [
                'name' => 'Nama Baru',
                'description' => 'Deskripsi diperbarui.',
                'address' => 'Mataram',
                'phone' => '081234567890',
                'latitude' => -8.5833000,
                'longitude' => 116.1160000,
            ]);

        $response->assertRedirect(route('merchant.shops.index'));

        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'name' => 'Nama Baru',
        ]);
    }

    /**
     * Merchant berhasil menghapus toko.
     */
    public function test_merchant_can_delete_own_shop(): void
    {
        $profile = MerchantProfile::factory()->create();

        $shop = Shop::factory()->create([
            'merchant_id' => $profile->id,
        ]);

        $response = $this->actingAs($profile->user)
            ->delete(route('merchant.shops.destroy', $shop->id));

        $response->assertRedirect(route('merchant.shops.index'));

        $this->assertDatabaseMissing('shops', [
            'id' => $shop->id,
        ]);
    }

    /**
     * Merchant tidak bisa mengubah toko milik merchant lain.
     */
    public function test_merchant_cannot_update_another_merchants_shop(): void
    {
        $merchant1 = MerchantProfile::factory()->create();
        $merchant2 = MerchantProfile::factory()->create();

        $shop = Shop::factory()->create([
            'merchant_id' => $merchant2->id,
            'name' => 'Toko Milik Merchant 2',
        ]);

        $response = $this->actingAs($merchant1->user)
            ->put(route('merchant.shops.update', $shop->id), [
                'name' => 'Toko Diubah',
                'description' => 'Percobaan mengubah toko.',
                'address' => 'Mataram',
                'phone' => '081234567890',
            ]);

        $response->assertNotFound();

        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'name' => 'Toko Milik Merchant 2',
        ]);
    }

    /**
     * Merchant tidak bisa menghapus toko milik merchant lain.
     */
    public function test_merchant_cannot_delete_another_merchants_shop(): void
    {
        $merchant1 = MerchantProfile::factory()->create();
        $merchant2 = MerchantProfile::factory()->create();

        $shop = Shop::factory()->create([
            'merchant_id' => $merchant2->id,
        ]);

        $response = $this->actingAs($merchant1->user)
            ->delete(route('merchant.shops.destroy', $shop->id));

        $response->assertNotFound();

        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
        ]);
    }
}
