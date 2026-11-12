<?php

namespace Tests\Unit;

use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_uses_correct_table(): void
    {
        $shop = new Shop();

        $this->assertEquals('shops', $shop->getTable());
    }

    public function test_shop_has_fillable_attributes(): void
    {
        $shop = new Shop();

        $this->assertContains('merchant_id', $shop->getFillable());
        $this->assertContains('name', $shop->getFillable());
        $this->assertContains('address', $shop->getFillable());
        $this->assertContains('phone', $shop->getFillable());
        $this->assertContains('is_active', $shop->getFillable());
    }

    public function test_shop_belongs_to_merchant_profile(): void
    {
        $shop = new Shop();

        $this->assertInstanceOf(
            BelongsTo::class,
            $shop->merchantProfile()
        );
    }

    public function test_shop_has_many_services(): void
    {
        $shop = new Shop();

        $this->assertInstanceOf(
            HasMany::class,
            $shop->services()
        );
    }

    public function test_shop_has_many_orders(): void
    {
        $shop = new Shop();

        $this->assertInstanceOf(
            HasMany::class,
            $shop->orders()
        );
    }
}
