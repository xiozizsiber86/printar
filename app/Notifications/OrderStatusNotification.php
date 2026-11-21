<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
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
        $statusLabels = [
            'pending' => 'Menunggu konfirmasi',
            'confirmed' => 'Pesanan dikonfirmasi',
            'processing' => 'Pesanan sedang diproses',
            'ready' => 'Pesanan siap diambil atau dikirim',
            'shipped' => 'Pesanan sedang dikirim',
            'completed' => 'Pesanan selesai',
            'cancelled' => 'Pesanan dibatalkan',
            'rejected' => 'Pesanan ditolak',
        ];

        $label = $statusLabels[$this->status] ?? $this->status;

        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->status,
            'status_label' => $label,
            'notes' => $this->notes,
            'message' => 'Status pesanan ' .
                $this->order->order_number .
                ' diperbarui menjadi ' . $label . '.',
        ];
    }
}
