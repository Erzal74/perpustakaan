<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleAndStatus
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // ✅ Cek apakah user disetujui oleh superadmin
        if ($user->status !== 'approved') {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum disetujui oleh Super Admin.',
            ]);
        }

        // ✅ Cek role pengguna
        if ($user->role !== $role) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
