<?php

namespace Tests\Unit;

use App\Models\Delivery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_delivery_model_uses_correct_table(): void
    {
        $delivery = new Delivery();

        $this->assertEquals('deliveries', $delivery->getTable());
    }

    public function test_delivery_model_has_fillable_attributes(): void
    {
        $delivery = new Delivery();

        $this->assertContains('order_id', $delivery->getFillable());
        $this->assertContains('delivery_method', $delivery->getFillable());
        $this->assertContains('courier_type', $delivery->getFillable());
        $this->assertContains('delivery_fee', $delivery->getFillable());
    }

    public function test_delivery_belongs_to_order(): void
    {
        $delivery = new Delivery();

        $this->assertInstanceOf(
            BelongsTo::class,
            $delivery->order()
        );
    }
}
