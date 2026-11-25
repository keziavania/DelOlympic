<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Redirect cerdas bagi pengguna yang sudah login saat mengakses /masuk atau /daftar
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            $user = Auth::user();
            if (! $user) {
                return route('home');
            }

            return match ($user->role) {
                'admin'         => route('admin.dashboard'),
                'penyelenggara' => route('penyelenggara.dashboard'),
                'peserta'       => route('peserta.dashboard'),
                default         => route('home'),
            };
        });
    }
}

