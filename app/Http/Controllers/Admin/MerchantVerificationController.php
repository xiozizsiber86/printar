<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MerchantProfile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MerchantVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $query = MerchantProfile::with('user')
            ->withCount('shops')
            ->latest();

        if ($request->filled('status')) {
            $query->where(
                'verification_status',
                $request->status
            );
        }

        $merchants = $query->paginate(15)->withQueryString();

        return view('admin.merchants.index', compact('merchants'));
    }

    public function show(int $id): View
    {
        $merchant = MerchantProfile::with([
            'user',
            'verifier',
            'documents',
            'shops',
        ])->findOrFail($id);

        return view('admin.merchants.show', compact('merchant'));
    }

    public function approve(int $id): RedirectResponse
    {
        $merchant = MerchantProfile::findOrFail($id);

        if ($merchant->verification_status !== 'pending') {
            return back()->with(
                'error',
                'Hanya pendaftaran Merchant yang menunggu verifikasi yang dapat disetujui.'
            );
        }

        $merchant->update([
            'verification_status' => 'approved',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('admin.merchants.show', $merchant->id)
            ->with('success', 'Pendaftaran Merchant berhasil disetujui.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $merchant = MerchantProfile::findOrFail($id);

        if ($merchant->verification_status !== 'pending') {
            return back()->with(
                'error',
                'Hanya pendaftaran Merchant yang menunggu verifikasi yang dapat ditolak.'
            );
        }

        $merchant->update([
            'verification_status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()
            ->route('admin.merchants.show', $merchant->id)
            ->with('success', 'Pendaftaran Merchant berhasil ditolak.');
    }
}
