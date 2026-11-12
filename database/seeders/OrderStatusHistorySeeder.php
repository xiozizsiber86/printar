<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatusHistory;
use Illuminate\Database\Seeder;

class OrderStatusHistorySeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::where(
            'order_number',
            'PRT-20261109-0001'
        )->first();

        $customer = User::where(
            'email',
            'customer@printar.com'
        )->first();

        if (!$order || !$customer) {
            return;
        }

        $histories = [
            [
                'status' => 'pending',
                'notes' => 'Pesanan berhasil dibuat oleh pelanggan.',
                'changed_by' => $customer->id,
            ],
        ];

        foreach ($histories as $history) {
            OrderStatusHistory::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'status' => $history['status'],
                ],
                [
                    'changed_by' => $history['changed_by'],
                    'notes' => $history['notes'],
                ]
            );
        }
    }
}
