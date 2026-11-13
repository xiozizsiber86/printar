<?php

namespace Tests\Feature;

use App\Models\Delivery;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchantOrderTest extends TestCase
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
        ]);

        return [$merchant, $shop];
    }

    private function createOrder(Shop $shop, string $status = 'pending'): Order
    {
        return Order::factory()->create([
            'shop_id' => $shop->id,
            'status' => $status,
        ]);
    }

    public function test_merchant_can_view_orders(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $this->createOrder($shop);

        $response = $this->actingAs($merchant)
            ->get(route('merchant.orders.index'));

        $response->assertOk();
    }

    public function test_merchant_can_view_own_order_detail(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop);

        $response = $this->actingAs($merchant)
            ->get(route('merchant.orders.show', $order->id));

        $response->assertOk();
    }

    public function test_merchant_cannot_view_another_merchants_order(): void
    {
        [$merchant] = $this->createMerchantWithShop();
        [, $otherShop] = $this->createMerchantWithShop();

        $order = $this->createOrder($otherShop);

        $response = $this->actingAs($merchant)
            ->get(route('merchant.orders.show', $order->id));

        $response->assertNotFound();
    }

    public function test_merchant_can_accept_pending_order(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop);

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.accept', $order->id));

        $response->assertRedirect(route('merchant.orders.show', $order->id));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('order_status_histories', [
            'order_id' => $order->id,
            'changed_by' => $merchant->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_merchant_can_reject_pending_order(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop);

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.reject', $order->id));

        $response->assertRedirect(route('merchant.orders.show', $order->id));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'rejected',
        ]);
    }

    public function test_merchant_can_start_processing_confirmed_order(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop, 'confirmed');

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.process', $order->id));

        $response->assertRedirect(route('merchant.orders.show', $order->id));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
        ]);

        $this->assertDatabaseHas('order_status_histories', [
            'order_id' => $order->id,
            'changed_by' => $merchant->id,
            'status' => 'processing',
        ]);
    }

    public function test_merchant_can_mark_processing_order_as_ready(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop, 'processing');

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.ready', $order->id));

        $response->assertRedirect(route('merchant.orders.show', $order->id));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'ready',
        ]);
    }

    public function test_merchant_cannot_accept_order_with_wrong_status(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop, 'confirmed');

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.accept', $order->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_merchant_can_mark_delivery_order_as_shipped(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop, 'ready');

        $delivery = Delivery::factory()->create([
            'order_id' => $order->id,
            'delivery_method' => 'delivery',
            'shipped_at' => null,
        ]);

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.shipped', $order->id));

        $response->assertRedirect(route('merchant.orders.show', $order->id));

        $this->assertNotNull($delivery->fresh()->shipped_at);
    }

    public function test_merchant_cannot_ship_pickup_order(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop, 'ready');

        Delivery::factory()->pickup()->create([
            'order_id' => $order->id,
        ]);

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.shipped', $order->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'ready',
        ]);
    }

    public function test_merchant_can_complete_pickup_order(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop, 'ready');

        Delivery::factory()->pickup()->create([
            'order_id' => $order->id,
        ]);

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.complete', $order->id));

        $response->assertRedirect(route('merchant.orders.show', $order->id));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('order_status_histories', [
            'order_id' => $order->id,
            'changed_by' => $merchant->id,
            'status' => 'completed',
        ]);
    }

    public function test_merchant_cannot_complete_delivery_order_before_shipping(): void
    {
        [$merchant, $shop] = $this->createMerchantWithShop();

        $order = $this->createOrder($shop, 'ready');

        Delivery::factory()->create([
            'order_id' => $order->id,
            'delivery_method' => 'delivery',
            'shipped_at' => null,
        ]);

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.complete', $order->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'ready',
        ]);
    }

    public function test_merchant_cannot_manage_another_merchants_order(): void
    {
        [$merchant] = $this->createMerchantWithShop();
        [, $otherShop] = $this->createMerchantWithShop();

        $order = $this->createOrder($otherShop);

        $response = $this->actingAs($merchant)
            ->post(route('merchant.orders.accept', $order->id));

        $response->assertNotFound();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);
    }
}
