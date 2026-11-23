<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Periksa apakah pengguna memiliki role yang diizinkan.
     *
     * Cara pakai di route: ->middleware('role:admin')
     * Bisa multi-role:     ->middleware('role:admin,penyelenggara')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        // Cek apakah role pengguna ada di daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Tambahan: blokir akun yang tidak aktif
        if ($user->status_akun !== 'aktif') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.']);
        }

        return $next($request);
    }
}
