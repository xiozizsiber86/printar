<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShopVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        $query = Shop::with([
            'merchantProfile.user',
        ])->withCount('services')->latest();

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('verification_status', $status);
        } else {
            $status = 'all';
        }

        $shops = $query->paginate(15)->withQueryString();

        return view('admin.shops.index', compact(
            'shops',
            'status'
        ));
    }

    public function show(int $id): View
    {
        $shop = Shop::with([
            'merchantProfile.user',
            'services.category',
        ])->findOrFail($id);

        return view('admin.shops.show', compact('shop'));
    }

    public function approve(int $id): RedirectResponse
    {
        $shop = Shop::findOrFail($id);

        if ($shop->verification_status !== 'pending') {
            return back()->with(
                'error',
                'Hanya toko yang menunggu verifikasi yang dapat disetujui.'
            );
        }

        if ($shop->merchantProfile?->verification_status !== 'approved') {
            return back()->with(
                'error',
                'Merchant harus disetujui terlebih dahulu.'
            );
        }

        $shop->update([
            'verification_status' => 'approved',
            'is_active' => true,
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('admin.shops.show', $shop->id)
            ->with('success', 'Toko berhasil disetujui dan diaktifkan.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $shop = Shop::findOrFail($id);

        if ($shop->verification_status !== 'pending') {
            return back()->with(
                'error',
                'Hanya toko yang menunggu verifikasi yang dapat ditolak.'
            );
        }

        $shop->update([
            'verification_status' => 'rejected',
            'is_active' => false,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()
            ->route('admin.shops.show', $shop->id)
            ->with('success', 'Toko berhasil ditolak.');
    }
}
