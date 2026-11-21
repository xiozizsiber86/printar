<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MerchantProfile;
use App\Models\Shop;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistik pengguna
        $totalUsers = User::count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalMerchants = MerchantProfile::count();

        // Statistik verifikasi merchant
        $pendingMerchants = MerchantProfile::where(
            'verification_status',
            'pending'
        )->count();

        $approvedMerchants = MerchantProfile::where(
            'verification_status',
            'approved'
        )->count();

        $rejectedMerchants = MerchantProfile::where(
            'verification_status',
            'rejected'
        )->count();

        // Statistik toko dan kategori
        $totalShops = Shop::count();

        $activeShops = Shop::where('is_active', true)->count();

        $totalCategories = Category::count();

        $activeCategories = Category::where('is_active', true)->count();

        // Statistik pesanan
        $totalOrders = Order::count();

        $activeOrders = Order::whereIn('status', [
            'pending',
            'confirmed',
            'processing',
            'ready',
        ])->count();

        $completedOrders = Order::where('status', 'completed')->count();

        $cancelledOrders = Order::whereIn('status', [
            'cancelled',
            'rejected',
        ])->count();

        // Statistik pembayaran
        $totalPayments = Payment::count();

        $waitingPayments = Payment::where(
            'status',
            'waiting_verification'
        )->count();

        $paidPayments = Payment::where('status', 'paid')->count();

        $rejectedPayments = Payment::where(
            'status',
            'rejected'
        )->count();

        $totalRevenue = Payment::where('status', 'paid')
            ->sum('amount');

        // Lima pesanan terbaru
        $latestOrders = Order::with([
            'user',
            'shop',
            'payment',
        ])
            ->latest()
            ->take(5)
            ->get();

        // Lima pembayaran terbaru
        $latestPayments = Payment::with([
            'order.user',
            'order.shop',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalCustomers',
            'totalMerchants',
            'pendingMerchants',
            'approvedMerchants',
            'rejectedMerchants',
            'totalShops',
            'activeShops',
            'totalCategories',
            'activeCategories',
            'totalOrders',
            'activeOrders',
            'completedOrders',
            'cancelledOrders',
            'totalPayments',
            'waitingPayments',
            'paidPayments',
            'rejectedPayments',
            'totalRevenue',
            'latestOrders',
            'latestPayments'
        ));
    }
}
