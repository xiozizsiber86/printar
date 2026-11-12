<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Menampilkan toko aktif dan mengurutkannya
     * berdasarkan jarak GPS pelanggan jika tersedia.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $latitude = $validated['latitude'] ?? null;
        $longitude = $validated['longitude'] ?? null;

        $hasLocation = $latitude !== null && $longitude !== null;

        $shops = Shop::query()
            ->where('is_active', true)
            ->with(['services' => function ($query) {
                $query->where('is_active', true);
            }])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($hasLocation, function ($query) use ($latitude, $longitude) {
                $query->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->select('shops.*')
                    ->selectRaw(
                        '(6371 * 2 * ASIN(SQRT(LEAST(1,
                            POWER(SIN(RADIANS(latitude - ?) / 2), 2) +
                            COS(RADIANS(?)) *
                            COS(RADIANS(latitude)) *
                            POWER(SIN(RADIANS(longitude - ?) / 2), 2)
                        )))) AS distance_km',
                        [$latitude, $latitude, $longitude]
                    )
                    ->orderBy('distance_km');
            })
            ->when(!$hasLocation, function ($query) {
                $query->latest();
            })
            ->paginate(10)
            ->withQueryString();

        return view('customer.shops.index', compact(
            'shops',
            'hasLocation'
        ));
    }

    /**
     * Menampilkan detail toko dan layanan yang tersedia.
     */
    public function show(int $id): View
    {
        $shop = Shop::where('is_active', true)
            ->with(['services' => function ($query) {
                $query->where('is_active', true)
                    ->with('category');
            }])
            ->findOrFail($id);

        return view('customer.shops.show', compact('shop'));
    }
}
