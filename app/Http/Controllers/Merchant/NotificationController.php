<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Menampilkan notifikasi milik merchant yang sedang login.
     */
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        $unreadCount = $request->user()
            ->unreadNotifications()
            ->count();

        return view('merchant.notifications.index', compact(
            'notifications',
            'unreadCount'
        ));
    }

    /**
     * Menandai satu notifikasi sebagai sudah dibaca.
     */
    public function read(Request $request, string $id): RedirectResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return back()->with(
            'success',
            'Notifikasi berhasil ditandai sudah dibaca.'
        );
    }

    /**
     * Menandai semua notifikasi sebagai sudah dibaca.
     */
    public function readAll(Request $request): RedirectResponse
    {
        $request->user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return back()->with(
            'success',
            'Semua notifikasi berhasil ditandai sudah dibaca.'
        );
    }
}
