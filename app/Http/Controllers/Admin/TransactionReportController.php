<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransactionReportController extends Controller
{
    private function validateFilters(Request $request): array
    {
        return $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
            'status' => [
                'nullable',
                'in:pending,confirmed,processing,ready,shipped,completed,cancelled,rejected',
            ],
            'payment_status' => [
                'nullable',
                'in:pending,waiting_verification,paid,failed,rejected,expired,refunded',
            ],
        ]);
    }

    private function filteredQuery(array $filters): Builder
    {
        return Order::query()
            ->when($filters['start_date'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($filters['end_date'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '<=', $date);
            })
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($filters['payment_status'] ?? null, function ($query, $status) {
                $query->whereHas('payment', function ($paymentQuery) use ($status) {
                    $paymentQuery->where('status', $status);
                });
            });
    }

    public function index(Request $request): View
    {
        $validated = $this->validateFilters($request);

        $baseQuery = Order::query()
            ->when($validated['start_date'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($validated['end_date'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '<=', $date);
            })
            ->when($validated['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            });

        $totalOrders = (clone $baseQuery)->count();

        $totalTransaction = (clone $baseQuery)->sum('total_price');

        $paidOrders = (clone $baseQuery)
            ->whereHas('payment', function ($query) {
                $query->where('status', 'paid');
            })
            ->with('payment')
            ->get();

        $paidRevenue = $paidOrders->sum(function ($order) {
            return (float) $order->payment->amount;
        });

        $waitingPayments = (clone $baseQuery)
            ->whereHas('payment', function ($query) {
                $query->where('status', 'waiting_verification');
            })
            ->count();

        $orders = $this->filteredQuery($validated)
            ->with(['user', 'shop', 'payment'])
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.reports.transactions', compact(
            'orders',
            'totalOrders',
            'totalTransaction',
            'paidRevenue',
            'waitingPayments',
            'validated'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $validated = $this->validateFilters($request);

        $orders = $this->filteredQuery($validated)
            ->with(['user', 'shop', 'payment'])
            ->latest('id')
            ->get();

        $filename = 'laporan-transaksi-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $output = fopen('php://output', 'w');

            // BOM agar karakter UTF-8 terbaca baik di Excel.
            fwrite($output, "\xEF\xBB\xBF");

            fputcsv($output, [
                'Nomor Pesanan',
                'Pelanggan',
                'Toko',
                'Total Transaksi',
                'Status Pesanan',
                'Status Pembayaran',
                'Metode Pembayaran',
                'Tanggal Transaksi',
            ], ';');

            foreach ($orders as $order) {
                $row = [
                    $order->order_number,
                    $order->user->name ?? '-',
                    $order->shop->name ?? '-',
                    $order->total_price,
                    $order->status,
                    $order->payment->status ?? 'belum ada',
                    $order->payment->method ?? '-',
                    $order->created_at?->format('d-m-Y H:i'),
                ];

                // Mencegah isi teks dianggap sebagai formula oleh spreadsheet.
                $row = array_map(function ($value) {
                    $value = (string) $value;

                    if (preg_match('/^[=+\-@\t\r]/', $value)) {
                        return "'" . $value;
                    }

                    return $value;
                }, $row);

                fputcsv($output, $row, ';', '"', '\\');
            }

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
