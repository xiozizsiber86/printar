<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pengguna berhasil mengganti password.
     */
    public function test_user_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password-lama'),
        ]);

        $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => 'password-lama',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ]);

        $this->assertTrue(
            Hash::check('password-baru', $user->fresh()->password)
        );
    }

    /**
     * Password lama harus benar.
     */
    public function test_user_cannot_update_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password-lama'),
        ]);

        $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => 'password-salah',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ])
            ->assertSessionHasErrorsIn('updatePassword', ['current_password']);

        $this->assertTrue(
            Hash::check('password-lama', $user->fresh()->password)
        );
    }

    /**
     * Password lama wajib diisi.
     */
    public function test_current_password_is_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => '',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ])
            ->assertSessionHasErrorsIn('updatePassword', ['current_password']);
    }

    /**
     * Password baru wajib diisi.
     */
    public function test_new_password_is_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => 'password',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertSessionHasErrorsIn('updatePassword', ['password']);
    }

    /**
     * Konfirmasi password harus cocok.
     */
    public function test_password_confirmation_must_match(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => 'password',
                'password' => 'password-baru',
                'password_confirmation' => 'password-berbeda',
            ])
            ->assertSessionHasErrorsIn('updatePassword', ['password']);
    }

    /**
     * Password baru harus berupa string.
     */
    public function test_new_password_must_be_string(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => 'password',
                'password' => ['password-baru'],
                'password_confirmation' => 'password-baru',
            ])
            ->assertSessionHasErrorsIn('updatePassword', ['password']);
    }

    /**
     * Password baru harus berbeda dari password lama.
     */
    public function test_user_can_update_password_and_old_password_no_longer_works(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password-lama'),
        ]);

        $this->actingAs($user)
            ->put('/user/password', [
                'current_password' => 'password-lama',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ]);

        $this->assertFalse(
            Hash::check('password-lama', $user->fresh()->password)
        );

        $this->assertTrue(
            Hash::check('password-baru', $user->fresh()->password)
        );
    }
}
