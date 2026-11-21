<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan milik pelanggan.
     */
    public function index(Request $request): View
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with(['shop', 'payment', 'delivery'])
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail dan pelacakan pesanan pelanggan.
     */
    public function show(Request $request, int $id): View
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with([
                'shop',
                'address',
                'items.files',
                'payment',
                'delivery',
                'statusHistories.changedBy',
            ])
            ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Membatalkan pesanan yang masih menunggu konfirmasi.
     */
    public function cancel(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $order = Order::where('user_id', $request->user()->id)
            ->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with(
                'error',
                'Pesanan tidak dapat dibatalkan karena sudah diproses merchant.'
            );
        }

        $reason = $request->input('cancellation_reason');

        DB::transaction(function () use ($order, $request, $reason) {
            $order->update([
                'status' => 'cancelled',
            ]);

            $order->statusHistories()->create([
                'changed_by' => $request->user()->id,
                'status' => 'cancelled',
                'notes' => $reason
                    ? 'Pesanan dibatalkan oleh pelanggan. Alasan: ' . $reason
                    : 'Pesanan dibatalkan oleh pelanggan.',
            ]);
        });

        // Kirim notifikasi kepada pemilik toko.
        $order->load('shop.merchantProfile.user');

        $merchant = $order->shop?->merchantProfile?->user;

        if ($merchant) {
            $notificationNotes = $reason
                ? 'Pesanan dibatalkan oleh pelanggan. Alasan: ' . $reason
                : 'Pesanan dibatalkan oleh pelanggan.';

            $merchant->notify(
                new OrderStatusNotification(
                    $order,
                    'cancelled',
                    $notificationNotes
                )
            );
        }

        return redirect()
            ->route('customer.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
