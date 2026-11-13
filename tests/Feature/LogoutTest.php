<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Customer berhasil logout.
     */
    public function test_customer_can_logout_successfully(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Merchant berhasil logout.
     */
    public function test_merchant_can_logout_successfully(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Admin berhasil logout.
     */
    public function test_admin_can_logout_successfully(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Guest tidak bisa melakukan logout.
     */
    public function test_guest_cannot_logout(): void
    {
        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Customer tidak bisa mengakses dashboard setelah logout.
     */
    public function test_customer_cannot_access_dashboard_after_logout(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $this->actingAs($user)->post('/logout');

        $response = $this->get('/customer/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Merchant tidak bisa mengakses dashboard setelah logout.
     */
    public function test_merchant_cannot_access_dashboard_after_logout(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => true,
        ]);

        $this->actingAs($user)->post('/logout');

        $response = $this->get('/merchant/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Admin tidak bisa mengakses dashboard setelah logout.
     */
    public function test_admin_cannot_access_dashboard_after_logout(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => true,
        ]);

        $this->actingAs($user)->post('/logout');

        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
