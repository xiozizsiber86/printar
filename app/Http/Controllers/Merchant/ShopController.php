<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shops = $merchantProfile->shops()
            ->latest()
            ->get();

        return view('merchant.shops.index', compact('shops'));
    }

    public function create(): View
    {
        return view('merchant.shops.create');
    }

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
            'verification_status' => 'pending',
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('merchant.shops.index')
            ->with('success', 'Toko berhasil ditambahkan dan menunggu verifikasi Admin.');
    }

    public function edit(Request $request, int $id): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shop = $merchantProfile->shops()->findOrFail($id);

        return view('merchant.shops.edit', compact('shop'));
    }

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

        $shop->update([
            ...$validated,
            'is_active' => false,
            'verification_status' => 'pending',
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('merchant.shops.index')
            ->with('success', 'Data toko diperbarui dan menunggu verifikasi ulang Admin.');
    }

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
