<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Menampilkan keranjang belanja pelanggan.
     */
    public function index(Request $request)
    {
        $cart = $request->user()
            ->cart()
            ->with(['shop', 'items.service'])
            ->first();

        return view('customer.cart.index', compact('cart'));
    }

    /**
     * Menambahkan layanan ke keranjang.
     */
    public function add(Request $request, $serviceId)
    {
        $user = $request->user();

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99999'],
        ]);

        $service = Service::with('shop')->findOrFail($serviceId);

        if (!$service->is_active || !$service->shop || !$service->shop->is_active) {
            return back()->with('error', 'Layanan atau toko sedang tidak aktif.');
        }

        $sameShop = DB::transaction(function () use ($user, $service, $validated) {
            $cart = Cart::firstOrCreate(
                ['user_id' => $user->id],
                ['shop_id' => $service->shop_id]
            );

            $cart = Cart::whereKey($cart->id)
                ->lockForUpdate()
                ->first();

            if ($cart->shop_id === null) {
                $cart->shop_id = $service->shop_id;
                $cart->save();
            }

            if ((int) $cart->shop_id !== (int) $service->shop_id) {
                return false;
            }

            $item = $cart->items()
                ->where('service_id', $service->id)
                ->lockForUpdate()
                ->first();

            $quantity = $validated['quantity'] + ($item?->quantity ?? 0);

            $cart->items()->updateOrCreate(
                ['service_id' => $service->id],
                [
                    'price' => $service->price,
                    'unit' => $service->unit,
                    'quantity' => $quantity,
                    'subtotal' => $service->price * $quantity,
                ]
            );

            return true;
        });

        if (!$sameShop) {
            return back()->with(
                'error',
                'Keranjang hanya dapat berisi layanan dari satu toko. Kosongkan keranjang terlebih dahulu untuk memilih toko lain.'
            );
        }

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Layanan berhasil ditambahkan ke keranjang.');
    }

    /**
     * Mengubah jumlah layanan di keranjang.
     */
    public function update(Request $request, $itemId)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99999'],
        ]);

        $cart = $request->user()->cart;

        if (!$cart) {
            abort(404);
        }

        $item = $cart->items()->findOrFail($itemId);

        $item->update([
            'quantity' => $validated['quantity'],
            'subtotal' => $item->price * $validated['quantity'],
        ]);

        return back()->with('success', 'Jumlah layanan berhasil diperbarui.');
    }

    /**
     * Menghapus satu layanan dari keranjang.
     */
    public function remove(Request $request, $itemId)
    {
        $cart = $request->user()->cart;

        if (!$cart) {
            abort(404);
        }

        DB::transaction(function () use ($cart, $itemId) {
            $cart->items()->findOrFail($itemId)->delete();

            if (!$cart->items()->exists()) {
                $cart->update(['shop_id' => null]);
            }
        });

        return back()->with('success', 'Layanan berhasil dihapus dari keranjang.');
    }

    /**
     * Mengosongkan seluruh keranjang.
     */
    public function clear(Request $request)
    {
        $cart = $request->user()->cart;

        if (!$cart) {
            return back()->with('success', 'Keranjang sudah kosong.');
        }

        DB::transaction(function () use ($cart) {
            $cart->items()->delete();
            $cart->update(['shop_id' => null]);
        });

        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
