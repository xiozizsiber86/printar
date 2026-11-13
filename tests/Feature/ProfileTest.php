<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pengguna berhasil mengubah nama.
     */
    public function test_user_can_update_name(): void
    {
        $user = User::factory()->create([
            'name' => 'Nama Lama',
            'email' => 'lama@example.com',
        ]);

        $this->actingAs($user)->put('/user/profile-information', [
            'name' => 'Nama Baru',
            'email' => 'lama@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'lama@example.com',
        ]);
    }

    /**
     * Pengguna berhasil mengubah email.
     */
    public function test_user_can_update_email(): void
    {
        $user = User::factory()->create([
            'email' => 'lama@example.com',
        ]);

        $this->actingAs($user)->put('/user/profile-information', [
            'name' => $user->name,
            'email' => 'baru@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'baru@example.com',
        ]);
    }

    /**
     * Pengguna berhasil mengubah nama dan email sekaligus.
     */
    public function test_user_can_update_name_and_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Nama Lama',
            'email' => 'lama@example.com',
        ]);

        $this->actingAs($user)->put('/user/profile-information', [
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
        ]);
    }

    /**
     * Pengguna tidak bisa menggunakan email milik pengguna lain.
     */
    public function test_user_cannot_update_email_to_existing_email(): void
    {
        $user = User::factory()->create([
            'email' => 'user1@example.com',
        ]);

        User::factory()->create([
            'email' => 'user2@example.com',
        ]);

        $this->actingAs($user)
            ->put('/user/profile-information', [
                'name' => $user->name,
                'email' => 'user2@example.com',
            ])
            ->assertSessionHasErrorsIn('updateProfileInformation', ['email']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'user1@example.com',
        ]);
    }

    /**
     * Nama wajib diisi.
     */
    public function test_name_is_required_when_updating_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/profile-information', [
                'name' => '',
                'email' => $user->email,
            ])
            ->assertSessionHasErrorsIn('updateProfileInformation', ['name']);
    }

    /**
     * Email wajib diisi.
     */
    public function test_email_is_required_when_updating_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/profile-information', [
                'name' => $user->name,
                'email' => '',
            ])
            ->assertSessionHasErrorsIn('updateProfileInformation', ['email']);
    }

    /**
     * Email harus memiliki format yang valid.
     */
    public function test_email_must_be_valid_when_updating_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/user/profile-information', [
                'name' => $user->name,
                'email' => 'email-tidak-valid',
            ])
            ->assertSessionHasErrorsIn('updateProfileInformation', ['email']);
    }
}
