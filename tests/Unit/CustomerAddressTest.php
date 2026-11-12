<?php

namespace Tests\Unit;

use App\Models\CustomerAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class CustomerAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_address_uses_correct_table(): void
    {
        $address = new CustomerAddress();

        $this->assertEquals('customer_addresses', $address->getTable());
    }

    public function test_customer_address_has_fillable_attributes(): void
    {
        $address = new CustomerAddress();

        $this->assertContains('user_id', $address->getFillable());
        $this->assertContains('label', $address->getFillable());
        $this->assertContains('recipient_name', $address->getFillable());
        $this->assertContains('phone', $address->getFillable());
        $this->assertContains('address', $address->getFillable());
        $this->assertContains('is_default', $address->getFillable());
    }

    public function test_customer_address_belongs_to_user(): void
    {
        $address = new CustomerAddress();

        $this->assertInstanceOf(
            BelongsTo::class,
            $address->user()
        );
    }

    public function test_customer_address_has_many_orders(): void
    {
        $address = new CustomerAddress();

        $this->assertInstanceOf(
            HasMany::class,
            $address->orders()
        );
    }
}
