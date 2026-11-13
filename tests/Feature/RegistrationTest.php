<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Customer berhasil mendaftar.
     */
    public function test_customer_can_register_successfully(): void
    {
        $response = $this->post('/register', [
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticated();

        $user = User::where('email', 'customer@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('customer', $user->role);
        $this->assertTrue((bool) $user->is_active);
        $this->assertTrue(Hash::check('Password123!', $user->password));
    }

    /**
     * Pendaftaran gagal jika nama kosong.
     */
    public function test_registration_requires_name(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'customer@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertGuest();
    }

    /**
     * Pendaftaran gagal jika email tidak valid.
     */
    public function test_registration_requires_valid_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Customer Test',
            'email' => 'email-tidak-valid',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Pendaftaran gagal jika email sudah digunakan.
     */
    public function test_registration_rejects_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'customer@example.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'Customer Baru',
            'email' => 'customer@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Pendaftaran gagal jika konfirmasi password tidak cocok.
     */
    public function test_registration_requires_matching_password_confirmation(): void
    {
        $response = $this->post('/register', [
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'PasswordBerbeda123!',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /**
     * Pendaftaran gagal jika password kosong.
     */
    public function test_registration_requires_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /**
     * Pendaftaran gagal jika konfirmasi password tidak diberikan.
     */
    public function test_registration_requires_password_confirmation(): void
    {
        $response = $this->post('/register', [
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }
}
