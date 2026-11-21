<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Notifications\PaymentStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    /**
     * Daftar pembayaran.
     */
    public function index(Request $request): View
    {
        $query = Payment::with([
            'order.user',
            'order.shop',
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Detail pembayaran.
     */
    public function show(int $paymentId): View
    {
        $payment = Payment::with([
            'order.user',
            'order.shop',
        ])->findOrFail($paymentId);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Melihat atau mengunduh bukti pembayaran.
     */
    public function proof(int $paymentId): StreamedResponse
    {
        $payment = Payment::findOrFail($paymentId);

        abort_if(
            !$payment->proof_file ||
            !Storage::disk('local')->exists($payment->proof_file),
            404,
            'Bukti pembayaran tidak ditemukan.'
        );

        return Storage::disk('local')->response(
            $payment->proof_file
        );
    }

    /**
     * Menyetujui pembayaran.
     */
    public function approve(
        Request $request,
        int $paymentId
    ): RedirectResponse {
        $payment = DB::transaction(function () use ($paymentId, $request) {
            $payment = Payment::with('order.user')
                ->lockForUpdate()
                ->findOrFail($paymentId);

            if (
                $payment->method !== 'manual_transfer' ||
                $payment->status !== 'waiting_verification'
            ) {
                return null;
            }

            $payment->update([
                'status' => 'paid',
                'verified_by' => $request->user()->id,
                'paid_at' => now(),
                'notes' => 'Pembayaran telah disetujui oleh Admin.',
            ]);

            return $payment;
        });

        if (!$payment) {
            return back()->with(
                'error',
                'Pembayaran ini tidak sedang menunggu verifikasi.'
            );
        }

        $payment->order->user->notify(
            new PaymentStatusNotification(
                $payment,
                'paid',
                'Pembayaran Anda telah berhasil diverifikasi oleh Admin.'
            )
        );

        return redirect()
            ->route('admin.payments.show', $payment->id)
            ->with('success', 'Pembayaran berhasil disetujui.');
    }

    /**
     * Menolak pembayaran.
     */
    public function reject(
        Request $request,
        int $paymentId
    ): RedirectResponse {
        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:500'],
        ]);

        $notes = trim($validated['notes']);

        $payment = DB::transaction(function () use (
            $paymentId,
            $request,
            $notes
        ) {
            $payment = Payment::with('order.user')
                ->lockForUpdate()
                ->findOrFail($paymentId);

            if (
                $payment->method !== 'manual_transfer' ||
                $payment->status !== 'waiting_verification'
            ) {
                return null;
            }

            $payment->update([
                'status' => 'rejected',
                'verified_by' => $request->user()->id,
                'paid_at' => null,
                'notes' => $notes,
            ]);

            return $payment;
        });

        if (!$payment) {
            return back()->with(
                'error',
                'Pembayaran ini tidak sedang menunggu verifikasi.'
            );
        }

        $payment->order->user->notify(
            new PaymentStatusNotification(
                $payment,
                'rejected',
                $notes
            )
        );

        return redirect()
            ->route('admin.payments.show', $payment->id)
            ->with('success', 'Pembayaran berhasil ditolak.');
    }
}
