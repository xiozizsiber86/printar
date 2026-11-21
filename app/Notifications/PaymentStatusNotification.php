<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Payment $payment,
        public string $status,
        public ?string $notes = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $order = $this->payment->order;

        $labels = [
            'paid' => 'Pembayaran berhasil diverifikasi',
            'rejected' => 'Pembayaran ditolak',
        ];

        $label = $labels[$this->status] ?? $this->status;

        return [
            'payment_id' => $this->payment->id,
            'order_id' => $order?->id,
            'order_number' => $order?->order_number,
            'status' => $this->status,
            'status_label' => $label,
            'notes' => $this->notes,
            'message' => 'Pembayaran pesanan ' .
                ($order?->order_number ?? '-') .
                ': ' . $label . '.',
        ];
    }
}
