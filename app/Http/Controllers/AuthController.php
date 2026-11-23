<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        // Jika sudah login, langsung redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.max'         => 'Email terlalu panjang.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
        ]);

        // Rate limiting: maksimal 5 percobaan per menit per email+IP
        $throttleKey = Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => "Terlalu banyak percobaan masuk. Coba lagi dalam {$seconds} detik.",
                ]);
        }

        // Coba autentikasi
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Cek status akun
            if ($user->status_akun === 'menunggu') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => 'Akun Anda sedang menunggu persetujuan admin. Harap tunggu konfirmasi melalui email.',
                    ]);
            }

            if ($user->status_akun === 'ditolak') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => 'Akun Anda telah ditolak. Silakan hubungi administrator untuk informasi lebih lanjut.',
                    ]);
            }

            // Reset rate limiter setelah berhasil login
            RateLimiter::clear($throttleKey);

            // Regenerasi sesi untuk keamanan
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return $this->redirectByRole($user);
        }

        // Login gagal — tambah hitungan rate limiter
        RateLimiter::hit($throttleKey, 60);

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau kata sandi yang Anda masukkan salah.',
            ]);
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Redirect pengguna ke dashboard sesuai role-nya.
     */
    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin'         => redirect()->route('admin.dashboard'),
            'penyelenggara' => redirect()->route('penyelenggara.dashboard'),
            'peserta'       => redirect()->route('peserta.dashboard'),
            default         => redirect()->route('login')->withErrors(['email' => 'Role akun tidak dikenali.']),
        };
    }
}
