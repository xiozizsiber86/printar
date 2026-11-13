<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_dashboard(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.dashboard'));

        $response->assertOk()
            ->assertViewIs('dashboard.customer');
    }

    public function test_merchant_cannot_access_customer_dashboard(): void
    {
        $merchant = User::factory()->create([
            'role' => 'merchant',
            'is_active' => true,
        ]);

        $response = $this->actingAs($merchant)
            ->get(route('customer.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_cannot_access_customer_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('customer.dashboard'));

        $response->assertForbidden();
    }

    public function test_guest_cannot_access_customer_dashboard(): void
    {
        $response = $this->get(route('customer.dashboard'));

        $response->assertRedirect(route('login'));
    }
}
