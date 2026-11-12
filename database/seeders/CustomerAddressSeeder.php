<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CustomerAddress;
use Illuminate\Database\Seeder;

class CustomerAddressSeeder extends Seeder
{
    public function run(): void
    {
        // Mencari akun customer
        $customer = User::updateOrCreate(
            ['email' => 'customer@printar.com'],
            [
                'name' => 'Andi Pratama',
                'password' => 'CustomerPrintar123!',
                'role' => 'customer',
                'is_active' => true,
            ]
        );

        // Membuat alamat utama customer
        CustomerAddress::updateOrCreate(
            [
                'user_id' => $customer->id,
                'label' => 'Rumah',
            ],
            [
                'recipient_name' => 'Andi Pratama',
                'phone' => '081234567891',
                'address' => 'Jl. Pendidikan No. 10, Kota Mataram, Nusa Tenggara Barat',
                'latitude' => -8.5833,
                'longitude' => 116.1167,
                'is_default' => true,
            ]
        );

        // Membuat alamat kedua customer
        CustomerAddress::updateOrCreate(
            [
                'user_id' => $customer->id,
                'label' => 'Kantor',
            ],
            [
                'recipient_name' => 'Andi Pratama',
                'phone' => '081234567891',
                'address' => 'Jl. Langko, Kota Mataram, Nusa Tenggara Barat',
                'latitude' => -8.5900,
                'longitude' => 116.1050,
                'is_default' => false,
            ]
        );
    }
}
