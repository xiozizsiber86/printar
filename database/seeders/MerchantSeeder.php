<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MerchantProfile;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun merchant
        $user = User::updateOrCreate(
            ['email' => 'merchant@printar.com'],
            [
                'name' => 'Budi Santoso',
                'password' => 'MerchantPrintar123!',
                'role' => 'merchant',
                'is_active' => true,
            ]
        );

        // Membuat profil merchant
        $merchant = MerchantProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => '081234567890',
                'verification_status' => 'approved',
                'verified_by' => User::where('email', 'admin@printar.com')->value('id'),
                'verified_at' => now(),
                'rejection_reason' => null,
            ]
        );

        // Membuat toko percetakan
        Shop::updateOrCreate(
            ['merchant_id' => $merchant->id],
            [
                'name' => 'Printar Digital Printing',
                'description' => 'Melayani cetak dokumen, fotokopi, banner, dan berbagai kebutuhan percetakan.',
                'address' => 'Kota Mataram, Nusa Tenggara Barat',
                'latitude' => -8.5833,
                'longitude' => 116.1167,
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
    }
}
