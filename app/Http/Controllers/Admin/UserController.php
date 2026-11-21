<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query
            ->with('merchantProfile')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(int $id): View
    {
        $user = User::with('merchantProfile')
            ->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function toggleStatus(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with(
                'error',
                'Anda tidak dapat menonaktifkan akun sendiri.'
            );
        }

        if ($user->role === 'admin') {
            return back()->with(
                'error',
                'Status akun Admin tidak dapat diubah melalui fitur ini.'
            );
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $message = $user->is_active
            ? 'Akun pengguna berhasil diaktifkan.'
            : 'Akun pengguna berhasil dinonaktifkan.';

        return redirect()
            ->route('admin.users.show', $user->id)
            ->with('success', $message);
    }
}
