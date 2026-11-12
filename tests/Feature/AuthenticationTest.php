<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Customer berhasil login.
     */
    public function test_customer_can_login_successfully(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Merchant berhasil login.
     */
    public function test_merchant_can_login_successfully(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => true,
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Admin berhasil login.
     */
    public function test_admin_can_login_successfully(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => true,
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Login gagal jika password salah.
     */
    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password-salah',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /**
     * Customer tidak bisa mengakses dashboard admin.
     */
    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/admin/dashboard');

        $response->assertForbidden();
    }

    /**
     * Merchant tidak bisa mengakses dashboard admin.
     */
    public function test_merchant_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/admin/dashboard');

        $response->assertForbidden();
    }

    /**
     * Admin tidak bisa mengakses dashboard merchant.
     */
    public function test_admin_cannot_access_merchant_dashboard(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/merchant/dashboard');

        $response->assertForbidden();
    }

    /**
     * Customer tidak bisa mengakses dashboard merchant.
     */
    public function test_customer_cannot_access_merchant_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/merchant/dashboard');

        $response->assertForbidden();
    }

    /**
     * Admin tidak bisa mengakses dashboard customer.
     */
    public function test_admin_cannot_access_customer_dashboard(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/customer/dashboard');

        $response->assertForbidden();
    }

    /**
     * Merchant tidak bisa mengakses dashboard customer.
     */
    public function test_merchant_cannot_access_customer_dashboard(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/customer/dashboard');

        $response->assertForbidden();
    }
}
