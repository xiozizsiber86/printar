<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Membuat akun admin awal
        User::updateOrCreate(
            ['email' => 'admin@printar.com'],
            [
                'name' => 'Administrator',
                'password' => 'AdminPrintar123!',
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Menjalankan CategorySeeder
        $this->call([
            CategorySeeder::class,
	    MerchantSeeder::class,
	    ServiceSeeder::class,
	    CustomerAddressSeeder::class,
	    OrderSeeder::class,
	    PaymentSeeder::class,
	    DeliverySeeder::class,
	    OrderStatusHistorySeeder::class,
        ]);
    }
}

