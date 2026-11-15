<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran pesanan.
     */
    public function show(Request $request, int $orderId)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with('payment')
            ->findOrFail($orderId);

        if (!$order->payment) {
            return back()->with(
                'error',
                'Data pembayaran untuk pesanan ini belum tersedia.'
            );
        }

        return view('customer.payments.show', compact('order'));
    }

    /**
     * Mengunggah bukti transfer.
     */
    public function uploadProof(Request $request, int $orderId)
    {
        $request->validate([
            'proof_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],
        ]);

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

        if (!in_array($payment->status, ['pending', 'rejected'])) {
            return back()->with(
                'error',
                'Bukti pembayaran tidak dapat diunggah pada status pembayaran ini.'
            );
        }

        // Hapus bukti lama jika Customer mengunggah ulang.
        if ($payment->proof_file) {
            Storage::disk('local')->delete($payment->proof_file);
        }

        $path = $request->file('proof_file')->store(
            'payment-proofs/' . $order->id,
            'local'
        );

        $payment->update([
            'method' => 'manual_transfer',
            'proof_file' => $path,
            'status' => 'waiting_verification',
            'notes' => 'Bukti transfer telah diunggah dan menunggu verifikasi Admin.',
        ]);

        return redirect()
            ->route('customer.payments.show', $order->id)
            ->with('success', 'Bukti transfer berhasil diunggah. Menunggu verifikasi Admin.');
    }
}
