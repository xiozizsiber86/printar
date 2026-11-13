<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use App\Models\MerchantProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerOrderTest extends TestCase
{
    use RefreshDatabase;

    private function createCustomer(): User
    {
        return User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);
    }

    private function createShop(): Shop
    {
        $merchant = User::factory()->merchant()->create();

        $profile = MerchantProfile::factory()->create([
            'user_id' => $merchant->id,
        ]);

        return Shop::factory()->create([
            'merchant_id' => $profile->id,
        ]);
    }

    public function test_customer_can_view_own_order_history(): void
    {
        $customer = $this->createCustomer();
        $shop = $this->createShop();

        Order::factory()->create([
            'user_id' => $customer->id,
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.orders.index'));

        $response->assertOk();
    }

    public function test_customer_can_view_own_order_detail(): void
    {
        $customer = $this->createCustomer();
        $shop = $this->createShop();

        $order = Order::factory()->create([
            'user_id' => $customer->id,
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.orders.show', $order->id));

        $response->assertOk();
    }

    public function test_customer_cannot_view_another_customers_order(): void
    {
        $customer = $this->createCustomer();
        $otherCustomer = $this->createCustomer();
        $shop = $this->createShop();

        $order = Order::factory()->create([
            'user_id' => $otherCustomer->id,
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.orders.show', $order->id));

        $response->assertNotFound();
    }

    public function test_customer_only_sees_own_orders_in_history(): void
    {
        $customer = $this->createCustomer();
        $otherCustomer = $this->createCustomer();
        $shop = $this->createShop();

        Order::factory()->create([
            'user_id' => $customer->id,
            'shop_id' => $shop->id,
        ]);

        Order::factory()->create([
            'user_id' => $otherCustomer->id,
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.orders.index'));

        $response->assertOk();
        $response->assertViewHas('orders', function ($orders) use ($customer) {
            return $orders->count() === 1
                && $orders->first()->user_id === $customer->id;
        });
    }

    public function test_guest_cannot_view_customer_order_history(): void
    {
        $response = $this->get(route('customer.orders.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_view_customer_order_detail(): void
    {
        $response = $this->get(route('customer.orders.show', 1));

        $response->assertRedirect(route('login'));
    }
}
