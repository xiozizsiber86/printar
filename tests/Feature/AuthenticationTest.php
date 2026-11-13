<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertForbidden();
    }

    public function test_merchant_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertForbidden();
    }

    public function test_admin_cannot_access_merchant_dashboard(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/merchant/dashboard');

        $response->assertForbidden();
    }

    public function test_customer_cannot_access_merchant_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/merchant/dashboard');

        $response->assertForbidden();
    }

    public function test_admin_cannot_access_customer_dashboard(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/customer/dashboard');

        $response->assertForbidden();
    }

    public function test_merchant_cannot_access_customer_dashboard(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/customer/dashboard');

        $response->assertForbidden();
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_guest_cannot_access_merchant_dashboard(): void
    {
        $response = $this->get('/merchant/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_guest_cannot_access_customer_dashboard(): void
    {
        $response = $this->get('/customer/dashboard');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Customer yang dinonaktifkan tidak bisa login.
     */
    public function test_inactive_customer_cannot_login(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
            'is_active' => false,
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Merchant yang dinonaktifkan tidak bisa login.
     */
    public function test_inactive_merchant_cannot_login(): void
    {
        $user = User::factory()->merchant()->create([
            'is_active' => false,
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Admin yang dinonaktifkan tidak bisa login.
     */
    public function test_inactive_admin_cannot_login(): void
    {
        $user = User::factory()->admin()->create([
            'is_active' => false,
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
