<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\MerchantProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MerchantProfile>
 */
class MerchantProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->merchant(),
            'phone' => fake()->phoneNumber(),
            'verification_status' => 'pending',
            'verified_by' => null,
            'verified_at' => null,
            'rejection_reason' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'approved',
            'verified_by' => User::factory()->admin(),
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'verification_status' => 'rejected',
            'verified_by' => User::factory()->admin(),
            'verified_at' => now(),
            'rejection_reason' => 'Dokumen persyaratan belum lengkap.',
        ]);
    }
}
