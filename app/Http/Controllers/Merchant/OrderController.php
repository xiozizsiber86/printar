<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\OrderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shops = $merchantProfile->shops()
            ->with(['orders.user', 'orders.payment'])
            ->latest()
            ->get();

        return view('merchant.orders.index', compact('shops'));
    }

    public function show(Request $request, int $id): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shop = $merchantProfile->shops()
            ->whereHas('orders', function ($query) use ($id) {
                $query->where('orders.id', $id);
            })
            ->firstOrFail();

        $order = $shop->orders()
            ->with([
                'user',
                'address',
                'items.service',
                'items.files',
                'payment',
                'delivery',
                'statusHistories.changedBy',
            ])
            ->findOrFail($id);

        return view('merchant.orders.show', compact('order'));
    }

    /**
     * Download file cetak milik pesanan toko merchant.
     */
    public function downloadFile(
        Request $request,
        int $id,
        int $fileId
    ): StreamedResponse {
        // Pastikan pesanan memang milik toko merchant yang login.
        $order = $this->findMerchantOrder($request, $id);

        // Pastikan file termasuk salah satu item pesanan tersebut.
        $file = OrderFile::whereHas('orderItem', function ($query) use ($order) {
            $query->where('order_id', $order->id);
        })->findOrFail($fileId);

        // Pastikan file benar-benar tersedia di penyimpanan.
        abort_unless(
            Storage::disk('local')->exists($file->file_path),
            404,
            'File cetak tidak ditemukan.'
        );

        return Storage::disk('local')->download(
            $file->file_path,
            basename($file->original_name)
        );
    }

    public function accept(Request $request, int $id): RedirectResponse
    {
        return $this->updateOrderStatus(
            $request,
            $id,
            'pending',
            'confirmed',
            'Pesanan berhasil diterima.',
            'Pesanan diterima oleh merchant.'
        );
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        return $this->updateOrderStatus(
            $request,
            $id,
            'pending',
            'rejected',
            'Pesanan berhasil ditolak.',
            'Pesanan ditolak oleh merchant.'
        );
    }

    public function startProcessing(Request $request, int $id): RedirectResponse
    {
        return $this->updateOrderStatus(
            $request,
            $id,
            'confirmed',
            'processing',
            'Pesanan mulai dikerjakan.',
            'Merchant mulai mengerjakan pesanan.'
        );
    }

    public function markReady(Request $request, int $id): RedirectResponse
    {
        return $this->updateOrderStatus(
            $request,
            $id,
            'processing',
            'ready',
            'Pesanan berhasil ditandai siap.',
            'Pesanan selesai dicetak dan siap diambil atau dikirim.'
        );
    }

    /**
     * Mencatat bahwa pesanan sudah diserahkan kepada kurir.
     */
    public function markShipped(Request $request, int $id): RedirectResponse
    {
        $order = $this->findMerchantOrder($request, $id);

        if ($order->status !== 'ready') {
            return back()->with('error', 'Pesanan belum siap dikirim.');
        }

        $delivery = $order->delivery;

        if (!$delivery || $delivery->delivery_method !== 'delivery') {
            return back()->with('error', 'Pesanan ini bukan pesanan pengiriman.');
        }

        if ($delivery->shipped_at) {
            return back()->with('error', 'Pesanan sudah ditandai dikirim.');
        }

        DB::transaction(function () use ($delivery) {
            $delivery->update([
                'shipped_at' => now(),
            ]);
        });

        return redirect()
            ->route('merchant.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil ditandai sudah dikirim.');
    }

    /**
     * Menyelesaikan pesanan yang sudah diterima atau diambil pelanggan.
     */
    public function complete(Request $request, int $id): RedirectResponse
    {
        $order = $this->findMerchantOrder($request, $id);

        if ($order->status !== 'ready') {
            return back()->with('error', 'Pesanan belum siap diselesaikan.');
        }

        $delivery = $order->delivery;

        if (!$delivery) {
            return back()->with('error', 'Data pengiriman pesanan tidak ditemukan.');
        }

        if (
            $delivery->delivery_method === 'delivery'
            && !$delivery->shipped_at
        ) {
            return back()->with('error', 'Pesanan harus dikirim terlebih dahulu.');
        }

        if ($order->status === 'completed') {
            return back()->with('error', 'Pesanan sudah selesai.');
        }

        DB::transaction(function () use ($order, $delivery, $request) {
            $delivery->update([
                'received_at' => now(),
            ]);

            $order->update([
                'status' => 'completed',
            ]);

            $order->statusHistories()->create([
                'changed_by' => $request->user()->id,
                'status' => 'completed',
                'notes' => 'Pesanan telah diterima atau diambil oleh pelanggan.',
            ]);
        });

        return redirect()
            ->route('merchant.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil diselesaikan.');
    }

    /**
     * Mengambil pesanan hanya jika dimiliki merchant yang sedang login.
     */
    private function findMerchantOrder(Request $request, int $id)
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shop = $merchantProfile->shops()
            ->whereHas('orders', function ($query) use ($id) {
                $query->where('orders.id', $id);
            })
            ->firstOrFail();

        return $shop->orders()
            ->with('delivery')
            ->findOrFail($id);
    }

    private function updateOrderStatus(
        Request $request,
        int $id,
        string $currentStatus,
        string $newStatus,
        string $message,
        string $notes
    ): RedirectResponse {
        $order = $this->findMerchantOrder($request, $id);

        if ($order->status !== $currentStatus) {
            return back()->with(
                'error',
                'Status pesanan tidak sesuai atau sudah diproses.'
            );
        }

        DB::transaction(function () use ($order, $request, $newStatus, $notes) {
            $order->update([
                'status' => $newStatus,
            ]);

            $order->statusHistories()->create([
                'changed_by' => $request->user()->id,
                'status' => $newStatus,
                'notes' => $notes,
            ]);
        });

        return redirect()
            ->route('merchant.orders.show', $order->id)
            ->with('success', $message);
    }
}
