<?php

namespace Tests\Unit;

use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_item_uses_correct_table(): void
    {
        $item = new OrderItem();

        $this->assertEquals('order_items', $item->getTable());
    }

    public function test_order_item_has_fillable_attributes(): void
    {
        $item = new OrderItem();

        $this->assertContains('order_id', $item->getFillable());
        $this->assertContains('service_id', $item->getFillable());
        $this->assertContains('service_name', $item->getFillable());
        $this->assertContains('price', $item->getFillable());
        $this->assertContains('unit', $item->getFillable());
        $this->assertContains('quantity', $item->getFillable());
        $this->assertContains('subtotal', $item->getFillable());
    }

    public function test_order_item_belongs_to_order(): void
    {
        $item = new OrderItem();

        $this->assertInstanceOf(
            BelongsTo::class,
            $item->order()
        );
    }

    public function test_order_item_belongs_to_service(): void
    {
        $item = new OrderItem();

        $this->assertInstanceOf(
            BelongsTo::class,
            $item->service()
        );
    }

    public function test_order_item_has_many_files(): void
    {
        $item = new OrderItem();

        $this->assertInstanceOf(
            HasMany::class,
            $item->files()
        );
    }
}

