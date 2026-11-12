<?php

namespace Tests\Unit;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_uses_correct_table(): void
    {
        $service = new Service();

        $this->assertEquals('services', $service->getTable());
    }

    public function test_service_has_fillable_attributes(): void
    {
        $service = new Service();

        $this->assertContains('shop_id', $service->getFillable());
        $this->assertContains('category_id', $service->getFillable());
        $this->assertContains('name', $service->getFillable());
        $this->assertContains('price', $service->getFillable());
        $this->assertContains('unit', $service->getFillable());
        $this->assertContains('is_active', $service->getFillable());
    }

    public function test_service_belongs_to_shop(): void
    {
        $service = new Service();

        $this->assertInstanceOf(
            BelongsTo::class,
            $service->shop()
        );
    }

    public function test_service_belongs_to_category(): void
    {
        $service = new Service();

        $this->assertInstanceOf(
            BelongsTo::class,
            $service->category()
        );
    }

    public function test_service_has_many_order_items(): void
    {
        $service = new Service();

        $this->assertInstanceOf(
            HasMany::class,
            $service->orderItems()
        );
    }
}
