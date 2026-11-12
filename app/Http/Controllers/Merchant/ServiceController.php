<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar layanan milik merchant.
     */
    public function index(Request $request): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shops = $merchantProfile->shops()
            ->with(['services.category'])
            ->latest()
            ->get();

        return view('merchant.services.index', compact('shops'));
    }

    /**
     * Menampilkan formulir tambah layanan.
     */
    public function create(Request $request): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shops = $merchantProfile->shops()
            ->where('is_active', true)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('merchant.services.create', compact('shops', 'categories'));
    }

    /**
     * Menyimpan layanan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shop_id' => ['required', 'integer'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
        ]);

        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shop = $merchantProfile->shops()
            ->where('is_active', true)
            ->findOrFail($validated['shop_id']);

        $shop->services()->create([
            ...$validated,
            'is_active' => false,
        ]);

        return redirect()
            ->route('merchant.services.index')
            ->with('success', 'Layanan berhasil ditambahkan dan menunggu aktivasi.');
    }

    /**
     * Menampilkan formulir edit layanan.
     */
    public function edit(Request $request, int $id): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $service = $merchantProfile->shops()
            ->whereHas('services', function ($query) use ($id) {
                $query->where('services.id', $id);
            })
            ->with('services')
            ->firstOrFail()
            ->services()
            ->findOrFail($id);

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('merchant.services.edit', compact('service', 'categories'));
    }

    /**
     * Memperbarui layanan.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
        ]);

        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $service = $merchantProfile->shops()
            ->whereHas('services', function ($query) use ($id) {
                $query->where('services.id', $id);
            })
            ->with('services')
            ->firstOrFail()
            ->services()
            ->findOrFail($id);

        $service->update($validated);

        return redirect()
            ->route('merchant.services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Menghapus layanan.
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $service = $merchantProfile->shops()
            ->whereHas('services', function ($query) use ($id) {
                $query->where('services.id', $id);
            })
            ->with('services')
            ->firstOrFail()
            ->services()
            ->findOrFail($id);

        $service->delete();

        return redirect()
            ->route('merchant.services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
