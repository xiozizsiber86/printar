<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $merchantProfile = $request->user()->merchantProfile;

        abort_if(!$merchantProfile, 404, 'Profil merchant tidak ditemukan.');

        $shopIds = $merchantProfile->shops()->select('id');

        $orders = Order::whereIn('shop_id', $shopIds);

        $totalOrders = (clone $orders)->count();

        $activeOrders = (clone $orders)
            ->whereIn('status', [
                'pending',
                'confirmed',
                'processing',
                'ready',
            ])
            ->count();

        $completedOrders = (clone $orders)
            ->where('status', 'completed')
            ->count();

        $cancelledOrders = (clone $orders)
            ->whereIn('status', ['cancelled', 'rejected'])
            ->count();

        $totalShops = $merchantProfile->shops()->count();

        $activeShops = $merchantProfile->shops()
            ->where('is_active', true)
            ->count();

        $totalServices = Service::whereHas('shop', function ($query) use ($merchantProfile) {
            $query->where('merchant_id', $merchantProfile->id);
        })->count();

        $activeServices = Service::where('is_active', true)
            ->whereHas('shop', function ($query) use ($merchantProfile) {
                $query->where('merchant_id', $merchantProfile->id);
            })
            ->count();

        $totalRevenue = Payment::where('status', 'paid')
            ->whereHas('order', function ($query) use ($shopIds) {
                $query->whereIn('shop_id', $shopIds);
            })
            ->sum('amount');

        $waitingPayments = Payment::where('status', 'waiting_verification')
            ->whereHas('order', function ($query) use ($shopIds) {
                $query->whereIn('shop_id', $shopIds);
            })
            ->count();

        $latestOrders = (clone $orders)
            ->with(['user', 'shop', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.merchant', compact(
            'totalOrders',
            'activeOrders',
            'completedOrders',
            'cancelledOrders',
            'totalShops',
            'activeShops',
            'totalServices',
            'activeServices',
            'totalRevenue',
            'waitingPayments',
            'latestOrders'
        ));
    }
}
