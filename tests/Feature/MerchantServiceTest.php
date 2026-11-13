<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\MerchantProfile;
use App\Models\Service;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchantServiceTest extends TestCase
{
    use RefreshDatabase;

    private function createMerchantWithShop(): array
    {
        $merchant = User::factory()->merchant()->create();

        $profile = MerchantProfile::factory()->create([
            'user_id' => $merchant->id,
        ]);

        $shop = Shop::factory()->create([
            'merchant_id' => $profile->id,
            'is_active' => true,
        ]);

        return [$merchant, $shop];
    }

    public function test_merchant_can_view_services(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        Service::factory()->create([
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($merchant)
            ->get(route('merchant.services.index'));

        $response->assertOk();
    }

    public function test_merchant_can_view_create_service_form(): void
    {
        [$merchant] = $this->createMerchantWithShop();

        $response = $this->actingAs($merchant)
            ->get(route('merchant.services.create'));

        $response->assertOk();
    }

    public function test_merchant_can_create_service(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();
        $category = Category::factory()->create();

        $response = $this->actingAs($merchant)
            ->post(route('merchant.services.store'), [
                'shop_id' => $shop->id,
                'category_id' => $category->id,
                'name' => 'Cetak Dokumen',
                'description' => 'Layanan cetak dokumen',
                'price' => 1000,
                'unit' => 'lembar',
            ]);

        $response->assertRedirect(route('merchant.services.index'));

        $this->assertDatabaseHas('services', [
            'shop_id' => $shop->id,
            'category_id' => $category->id,
            'name' => 'Cetak Dokumen',
            'is_active' => false,
        ]);
    }

    public function test_new_service_is_inactive_by_default(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();
        $category = Category::factory()->create();

        $this->actingAs($merchant)
            ->post(route('merchant.services.store'), [
                'shop_id' => $shop->id,
                'category_id' => $category->id,
                'name' => 'Cetak Foto',
                'price' => 2000,
                'unit' => 'lembar',
            ]);

        $this->assertDatabaseHas('services', [
            'shop_id' => $shop->id,
            'name' => 'Cetak Foto',
            'is_active' => false,
        ]);
    }

    public function test_merchant_cannot_add_service_to_another_merchants_shop(): void
    {
        [$merchant] = $this->createMerchantWithShop();
        [, $otherShop] = $this->createMerchantWithShop();
        $category = Category::factory()->create();

        $response = $this->actingAs($merchant)
            ->post(route('merchant.services.store'), [
                'shop_id' => $otherShop->id,
                'category_id' => $category->id,
                'name' => 'Cetak Dokumen',
                'price' => 1000,
                'unit' => 'lembar',
            ]);

        $response->assertNotFound();
    }

    public function test_merchant_cannot_add_service_to_inactive_shop(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();
        $shop->update(['is_active' => false]);
        $category = Category::factory()->create();

        $response = $this->actingAs($merchant)
            ->post(route('merchant.services.store'), [
                'shop_id' => $shop->id,
                'category_id' => $category->id,
                'name' => 'Cetak Dokumen',
                'price' => 1000,
                'unit' => 'lembar',
            ]);

        $response->assertNotFound();
    }

    public function test_service_name_is_required(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();
        $category = Category::factory()->create();

        $response = $this->actingAs($merchant)
            ->post(route('merchant.services.store'), [
                'shop_id' => $shop->id,
                'category_id' => $category->id,
                'price' => 1000,
                'unit' => 'lembar',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_merchant_can_view_edit_service_form(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();
        $service = Service::factory()->create([
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($merchant)
            ->get(route('merchant.services.edit', $service->id));

        $response->assertOk();
    }

    public function test_merchant_can_update_own_service(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();
        $service = Service::factory()->create([
            'shop_id' => $shop->id,
        ]);

        $category = Category::factory()->create();

        $response = $this->actingAs($merchant)
            ->put(route('merchant.services.update', $service->id), [
                'category_id' => $category->id,
                'name' => 'Cetak Banner',
                'description' => 'Cetak banner berkualitas',
                'price' => 15000,
                'unit' => 'meter',
            ]);

        $response->assertRedirect(route('merchant.services.index'));

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Cetak Banner',
            'price' => 15000,
            'unit' => 'meter',
        ]);
    }

    public function test_merchant_can_delete_own_service(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();
        $service = Service::factory()->create([
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($merchant)
            ->delete(route('merchant.services.destroy', $service->id));

        $response->assertRedirect(route('merchant.services.index'));

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_merchant_cannot_edit_another_merchants_service(): void
    {
        [$merchant] = $this->createMerchantWithShop();
        [, $otherShop] = $this->createMerchantWithShop();

        $service = Service::factory()->create([
            'shop_id' => $otherShop->id,
        ]);

        $response = $this->actingAs($merchant)
            ->get(route('merchant.services.edit', $service->id));

        $response->assertNotFound();
    }

    public function test_merchant_cannot_update_another_merchants_service(): void
    {
        [$merchant] = $this->createMerchantWithShop();
        [, $otherShop] = $this->createMerchantWithShop();

        $service = Service::factory()->create([
            'shop_id' => $otherShop->id,
        ]);

        $category = Category::factory()->create();

        $response = $this->actingAs($merchant)
            ->put(route('merchant.services.update', $service->id), [
                'category_id' => $category->id,
                'name' => 'Layanan Diubah',
                'price' => 5000,
                'unit' => 'lembar',
            ]);

        $response->assertNotFound();
    }

    public function test_merchant_cannot_delete_another_merchants_service(): void
    {
        [$merchant] = $this->createMerchantWithShop();
        [, $otherShop] = $this->createMerchantWithShop();

        $service = Service::factory()->create([
            'shop_id' => $otherShop->id,
        ]);

        $response = $this->actingAs($merchant)
            ->delete(route('merchant.services.destroy', $service->id));

        $response->assertNotFound();
    }
}
