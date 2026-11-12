<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
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
}
