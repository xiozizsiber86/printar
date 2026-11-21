<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Menampilkan detail pembayaran pesanan.
     */
    public function show(Request $request, $orderId)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with('payment')
            ->findOrFail($orderId);

        if (!$order->payment) {
            return redirect()
                ->route('customer.orders.show', $order->id)
                ->with('error', 'Data pembayaran tidak ditemukan.');
        }

        return view('customer.payments.show', compact('order'));
    }

    /**
     * Mengunggah bukti pembayaran Transfer Manual.
     */
    public function uploadProof(Request $request, $orderId)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with('payment')
            ->findOrFail($orderId);

        $payment = $order->payment;

        if (!$payment) {
            return back()->with(
                'error',
                'Data pembayaran tidak ditemukan.'
            );
        }

        // Upload bukti hanya diperbolehkan untuk Transfer Manual.
        if ($payment->method !== 'manual_transfer') {
            return back()->with(
                'error',
                'Upload bukti hanya tersedia untuk pembayaran Transfer Manual.'
            );
        }

        // Bukti hanya bisa diunggah ketika pembayaran pending atau rejected.
        if (!in_array($payment->status, ['pending', 'rejected'], true)) {
            return back()->with(
                'error',
                'Bukti pembayaran tidak dapat diunggah pada status pembayaran saat ini.'
            );
        }

        $validated = $request->validate([
            'proof_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],
        ], [
            'proof_file.required' => 'Silakan pilih bukti pembayaran.',
            'proof_file.mimes' => 'Bukti harus berupa JPG, JPEG, PNG, atau PDF.',
            'proof_file.max' => 'Ukuran bukti pembayaran maksimal 10 MB.',
        ]);

        // Hapus bukti lama jika pelanggan mengunggah ulang.
        if ($payment->proof_file) {
            Storage::disk('public')->delete($payment->proof_file);
        }

        // Simpan bukti pembayaran.
        $proofPath = $validated['proof_file']->store(
            'payment-proofs/' . $order->id,
            'public'
        );

        // Perbarui data pembayaran.
        $payment->update([
            'proof_file' => $proofPath,
            'status' => 'waiting_verification',
            'notes' => 'Bukti pembayaran telah diunggah dan menunggu verifikasi Admin.',
        ]);

        return redirect()
            ->route('customer.payments.show', $order->id)
            ->with(
                'success',
                'Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi Admin.'
            );
    }
}
