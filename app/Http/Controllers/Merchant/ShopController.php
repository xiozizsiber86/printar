<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Menampilkan daftar toko milik merchant.
     */
    public function index(Request $request): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shops = $merchantProfile->shops()
            ->latest()
            ->get();

        return view('merchant.shops.index', compact('shops'));
    }

    /**
     * Menampilkan formulir tambah toko.
     */
    public function create(): View
    {
        return view('merchant.shops.create');
    }

    /**
     * Menyimpan toko baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $merchantProfile->shops()->create([
            ...$validated,
            'is_active' => false,
        ]);

        return redirect()
            ->route('merchant.shops.index')
            ->with('success', 'Toko berhasil ditambahkan dan menunggu aktivasi.');
    }

    /**
     * Menampilkan formulir edit toko.
     */
    public function edit(Request $request, int $id): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shop = $merchantProfile->shops()->findOrFail($id);

        return view('merchant.shops.edit', compact('shop'));
    }

    /**
     * Memperbarui data toko.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shop = $merchantProfile->shops()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $shop->update($validated);

        return redirect()
            ->route('merchant.shops.index')
            ->with('success', 'Data toko berhasil diperbarui.');
    }

    /**
     * Menghapus toko milik merchant.
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shop = $merchantProfile->shops()->findOrFail($id);

        $shop->delete();

        return redirect()
            ->route('merchant.shops.index')
            ->with('success', 'Toko berhasil dihapus.');
    }
}
