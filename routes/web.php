<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes — Del Olympic
|--------------------------------------------------------------------------
|
| Semua route aplikasi web didefinisikan di sini.
| Route dikelompokkan berdasarkan akses (publik / auth / role).
|
*/

// ============================================================
// ROUTE PUBLIK — Halaman Landing (Welcome)
// ============================================================
Route::get('/', function () {
    return view('welcome');
})->name('home');


// ============================================================
// ROUTE AUTH — Login & Logout
// ============================================================
Route::middleware('guest')->group(function () {
    // Halaman form login (GET)
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');

    // Proses login (POST)
    Route::post('/masuk', [AuthController::class, 'login'])->name('login.post');

    // Placeholder untuk halaman daftar (akan dibuat teman kamu)
    Route::get('/daftar', function () {
        return view('auth.register');
    })->name('register');
});

// Logout (harus sudah login)
Route::post('/keluar', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ============================================================
// ROUTE DASHBOARD — Dilindungi oleh Auth + Role Middleware
// ============================================================

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    // Route-route admin lainnya bisa ditambahkan di sini
});

// Dashboard Penyelenggara
Route::middleware(['auth', 'role:penyelenggara'])->prefix('penyelenggara')->name('penyelenggara.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'penyelenggaraDashboard'])->name('dashboard');
    // Route-route penyelenggara lainnya bisa ditambahkan di sini
});

// Dashboard Peserta
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pesertaDashboard'])->name('dashboard');
    // Route-route peserta lainnya bisa ditambahkan di sini
});
