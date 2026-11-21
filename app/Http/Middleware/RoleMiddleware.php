<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $role,
        ?string $verification = null
    ): Response {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        if ($user->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Verifikasi hanya diwajibkan pada fitur tertentu.
        if ($role === 'merchant' && $verification === 'approved') {
            $merchantProfile = $user->merchantProfile;

            if (
                !$merchantProfile ||
                $merchantProfile->verification_status !== 'approved'
            ) {
                abort(
                    403,
                    'Fitur ini hanya dapat digunakan setelah akun Merchant disetujui Admin.'
                );
            }
        }

        return $next($request);
    }
}
