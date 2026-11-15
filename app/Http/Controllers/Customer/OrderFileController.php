<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderFile;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderFileController extends Controller
{
    public function store(Request $request, int $orderId, int $itemId)
    {
        $request->validate([
            'files' => ['required', 'array', 'min:1', 'max:10'],
            'files.*' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        $order = Order::where('user_id', $request->user()->id)
            ->findOrFail($orderId);

        $item = OrderItem::where('order_id', $order->id)
            ->findOrFail($itemId);

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with(
                'error',
                'File hanya dapat diunggah ketika pesanan menunggu konfirmasi atau sudah diterima.'
            );
        }

        foreach ($request->file('files') as $file) {
            $path = $file->store(
                'order-files/' . $order->id . '/' . $item->id,
                'local'
            );

            OrderFile::create([
                'order_item_id' => $item->id,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return back()->with('success', 'File cetak berhasil diunggah.');
    }

    public function destroy(Request $request, int $orderId, int $fileId)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->findOrFail($orderId);

        $file = OrderFile::whereHas('orderItem', function ($query) use ($order) {
            $query->where('order_id', $order->id);
        })->findOrFail($fileId);

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with(
                'error',
                'File tidak dapat dihapus setelah pesanan mulai diproses.'
            );
        }

        Storage::disk('local')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'File cetak berhasil dihapus.');
    }
}
