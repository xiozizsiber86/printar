<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_uses_correct_table(): void
    {
        $user = new User();

        $this->assertEquals('users', $user->getTable());
    }

    public function test_user_has_fillable_attributes(): void
    {
        $user = new User();

        $this->assertContains('name', $user->getFillable());
        $this->assertContains('email', $user->getFillable());
    }

    public function test_user_hides_password_and_remember_token(): void
    {
        $user = new User();

        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
    }

    public function test_user_has_one_merchant_profile(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            HasOne::class,
            $user->merchantProfile()
        );
    }

    public function test_user_has_many_customer_addresses(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            HasMany::class,
            $user->customerAddresses()
        );
    }

    public function test_user_has_many_orders(): void
    {
        $user = new User();

        $this->assertInstanceOf(
            HasMany::class,
            $user->orders()
        );
    }
}
