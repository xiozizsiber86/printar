<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
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

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'method' => 'manual_transfer',
                'amount' => $order->total_price,
                'status' => 'waiting_verification',
                'proof_file' => null,
                'gateway_reference' => null,
                'verified_by' => null,
                'paid_at' => null,
                'notes' => 'Menunggu verifikasi bukti pembayaran.',
            ]
        );
    }
}
