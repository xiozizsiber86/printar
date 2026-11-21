<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceVerificationController extends Controller
{
    /**
     * Daftar layanan untuk verifikasi Admin.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        $query = Service::with([
            'shop.merchantProfile.user',
            'category',
        ])->latest();

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('verification_status', $status);
        } else {
            $status = 'all';
        }

        $services = $query->paginate(15)->withQueryString();

        return view('admin.services.index', compact(
            'services',
            'status'
        ));
    }

    /**
     * Detail layanan.
     */
    public function show(int $id): View
    {
        $service = Service::with([
            'shop.merchantProfile.user',
            'category',
        ])->findOrFail($id);

        return view('admin.services.show', compact('service'));
    }

    /**
     * Menyetujui layanan.
     */
    public function approve(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);

        if ($service->verification_status !== 'pending') {
            return back()->with(
                'error',
                'Hanya layanan yang menunggu verifikasi yang dapat disetujui.'
            );
        }

        $service->update([
            'verification_status' => 'approved',
            'is_active' => true,
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('admin.services.show', $service->id)
            ->with('success', 'Layanan berhasil disetujui dan diaktifkan.');
    }

    /**
     * Menolak layanan.
     */
    public function reject(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $service = Service::findOrFail($id);

        if ($service->verification_status !== 'pending') {
            return back()->with(
                'error',
                'Hanya layanan yang menunggu verifikasi yang dapat ditolak.'
            );
        }

        $service->update([
            'verification_status' => 'rejected',
            'is_active' => false,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()
            ->route('admin.services.show', $service->id)
            ->with('success', 'Layanan berhasil ditolak.');
    }
}
