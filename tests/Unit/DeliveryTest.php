<?php

namespace Tests\Unit;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $this->assertEquals([
            'order_id',
            'delivery_method',
            'courier_type',
            'courier_name',
            'courier_phone',
            'delivery_address',
            'delivery_fee',
            'shipped_at',
            'received_at',
            'notes',
        ], $delivery->getFillable());
    }

    public function test_delivery_belongs_to_order(): void
    {
        $delivery = new Delivery();

        $this->assertInstanceOf(
            BelongsTo::class,
            $delivery->order()
        );
    }

    public function test_delivery_has_correct_attribute_casts(): void
    {
        $delivery = new Delivery();

        $casts = $delivery->getCasts();

        $this->assertEquals('decimal:2', $casts['delivery_fee']);
        $this->assertEquals('datetime', $casts['shipped_at']);
        $this->assertEquals('datetime', $casts['received_at']);
    }
}
