<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $cart = $user->cart()
            ->with(['shop', 'items.service'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        $addresses = CustomerAddress::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        if ($addresses->isEmpty()) {
            return redirect()->route('customer.addresses.index')
                ->with('error', 'Silakan tambahkan alamat terlebih dahulu.');
        }

        return view('customer.checkout.index', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'address_id' => [
                'required',
                'integer',
                'exists:customer_addresses,id',
            ],
            'delivery_method' => [
                'required',
                'in:pickup,delivery',
            ],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $address = CustomerAddress::where('user_id', $user->id)
            ->findOrFail($validated['address_id']);

        $order = DB::transaction(function () use (
            $user,
            $address,
            $validated
        ) {
            $cart = Cart::where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if (!$cart) {
                return null;
            }

            $cart->load(['items.service.shop']);

            if ($cart->items->isEmpty()) {
                return null;
            }

            $subtotal = 0;

            foreach ($cart->items as $item) {
                $service = $item->service;

                if (
                    !$service ||
                    !$service->is_active ||
                    !$service->shop ||
                    !$service->shop->is_active ||
                    (int) $service->shop_id !== (int) $cart->shop_id
                ) {
                    abort(
                        422,
                        'Ada layanan atau toko yang sudah tidak aktif. Periksa kembali keranjang Anda.'
                    );
                }

                $subtotal += (float) $service->price * $item->quantity;
            }

            $deliveryFee = 0;

            $order = Order::create([
                'user_id' => $user->id,
                'shop_id' => $cart->shop_id,
                'address_id' => $address->id,
                'order_number' => 'PRT-' . strtoupper((string) Str::uuid()),
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_price' => $subtotal + $deliveryFee,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            foreach ($cart->items as $item) {
                $service = $item->service;
                $price = (float) $service->price;

                $order->items()->create([
                    'service_id' => $service->id,
                    'service_name' => $service->name,
                    'price' => $price,
                    'unit' => $service->unit,
                    'quantity' => $item->quantity,
                    'subtotal' => $price * $item->quantity,
                ]);
            }

            // Buat data pengiriman
            $order->delivery()->create([
                'delivery_method' => $validated['delivery_method'],
                'courier_type' => null,
                'delivery_address' => $validated['delivery_method'] === 'delivery'
                    ? $address->address
                    : null,
                'delivery_fee' => $deliveryFee,
            ]);

            // Buat riwayat status awal pesanan
            $order->statusHistories()->create([
                'changed_by' => $user->id,
                'status' => 'pending',
                'notes' => 'Pesanan dibuat oleh pelanggan.',
            ]);

            // Buat data pembayaran awal
            Payment::create([
                'order_id' => $order->id,
                'method' => 'manual_transfer',
                'amount' => $order->total_price,
                'status' => 'pending',
                'notes' => 'Menunggu pembayaran dari pelanggan.',
            ]);

            // Kosongkan keranjang setelah pesanan berhasil dibuat
            $cart->items()->delete();
            $cart->update(['shop_id' => null]);

            return $order;
        });

        if (!$order) {
            return redirect()->route('customer.cart.index')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        return redirect()->route('customer.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat.');
    }
}
