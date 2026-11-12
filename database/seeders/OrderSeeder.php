<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Service;
use App\Models\OrderItem;
use App\Models\CustomerAddress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('email', 'customer@printar.com')->first();
        $shop = Shop::where('name', 'Printar Digital Printing')->first();
        $address = CustomerAddress::where('user_id', $customer?->id)
            ->where('label', 'Rumah')
            ->first();

        if (!$customer || !$shop || !$address) {
            return;
        }

        $services = [
            [
                'name' => 'Cetak Dokumen Hitam Putih',
                'quantity' => 20,
            ],
            [
                'name' => 'Cetak Dokumen Warna',
                'quantity' => 5,
            ],
            [
                'name' => 'Laminating A4',
                'quantity' => 2,
            ],
        ];

        $orderNumber = 'PRT-' . now()->format('Ymd') . '-0001';

        $order = Order::updateOrCreate(
            ['order_number' => $orderNumber],
            [
                'user_id' => $customer->id,
                'shop_id' => $shop->id,
                'address_id' => $address->id,
                'subtotal' => 0,
                'delivery_fee' => 5000,
                'total_price' => 0,
                'notes' => 'Mohon cetak dengan hasil yang jelas dan rapi.',
                'status' => 'pending',
            ]
        );

        $subtotal = 0;

        foreach ($services as $item) {
            $service = Service::where('shop_id', $shop->id)
                ->where('name', $item['name'])
                ->first();

            if (!$service) {
                continue;
            }

            $itemSubtotal = $service->price * $item['quantity'];
            $subtotal += $itemSubtotal;

            OrderItem::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'service_name' => $service->name,
                ],
                [
                    'service_id' => $service->id,
	            'service_name' => $service->name,
                    'price' => $service->price,
                    'unit' => $service->unit,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                ]
            );
        }

        $order->update([
            'subtotal' => $subtotal,
            'total_price' => $subtotal + $order->delivery_fee,
        ]);
    }
}
