<?php

namespace Tests\Unit;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_uses_correct_table(): void
    {
        $order = new Order();

        $this->assertEquals('orders', $order->getTable());
    }

    public function test_order_has_fillable_attributes(): void
    {
        $order = new Order();

        $this->assertContains('user_id', $order->getFillable());
        $this->assertContains('shop_id', $order->getFillable());
        $this->assertContains('address_id', $order->getFillable());
        $this->assertContains('order_number', $order->getFillable());
        $this->assertContains('subtotal', $order->getFillable());
        $this->assertContains('delivery_fee', $order->getFillable());
        $this->assertContains('total_price', $order->getFillable());
        $this->assertContains('status', $order->getFillable());
    }

    public function test_order_belongs_to_user(): void
    {
        $order = new Order();

        $this->assertInstanceOf(BelongsTo::class, $order->user());
    }

    public function test_order_belongs_to_shop(): void
    {
        $order = new Order();

        $this->assertInstanceOf(BelongsTo::class, $order->shop());
    }

    public function test_order_belongs_to_address(): void
    {
        $order = new Order();

        $this->assertInstanceOf(BelongsTo::class, $order->address());
    }

    public function test_order_has_many_items(): void
    {
        $order = new Order();

        $this->assertInstanceOf(HasMany::class, $order->items());
    }

    public function test_order_has_one_payment(): void
    {
        $order = new Order();

        $this->assertInstanceOf(HasOne::class, $order->payment());
    }

    public function test_order_has_one_delivery(): void
    {
        $order = new Order();

        $this->assertInstanceOf(HasOne::class, $order->delivery());
    }

    public function test_order_has_many_status_histories(): void
    {
        $order = new Order();

        $this->assertInstanceOf(HasMany::class, $order->statusHistories());
    }
}
