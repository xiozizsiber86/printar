<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::where(
            'order_number',
            'PRT-20261109-0001'
        )->first();

        if (!$order) {
            return;
        }

        Delivery::updateOrCreate(
            ['order_id' => $order->id],
            [
                'delivery_method' => 'delivery',
                'courier_type' => 'merchant',
                'courier_name' => 'Kurir Printar',
                'courier_phone' => '081234567890',
                'delivery_address' => $order->address?->address,
                'delivery_fee' => $order->delivery_fee,
                'shipped_at' => null,
                'received_at' => null,
                'notes' => 'Pengiriman akan dilakukan setelah pesanan selesai dicetak.',
            ]
        );
    }
}
