<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesertaDashboardController;

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

    // Halaman pendaftaran akun (GET)
    Route::get('/daftar', [RegisterController::class, 'showRegister'])->name('register');

    // Proses pendaftaran akun (POST)
    Route::post('/daftar', [RegisterController::class, 'register'])->name('register.post');
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
    Route::get('/dashboard', [PesertaDashboardController::class, 'index'])->name('dashboard');

    // Jelajah & Detail Lomba Menyeluruh
    Route::get('/lomba', [PesertaDashboardController::class, 'explore'])->name('competitions.index');
    Route::get('/lomba/{competition}', [PesertaDashboardController::class, 'showCompetition'])->name('competitions.show');
    Route::post('/lomba/{competition}/daftar', [PesertaDashboardController::class, 'registerCompetition'])->name('competitions.register');

    // Lomba Saya, Unggah Berkas, & Kartu Peserta
    Route::get('/lomba-saya', [PesertaDashboardController::class, 'myCompetitions'])->name('registrations.index');
    Route::post('/lomba-saya/{registration}/berkas', [PesertaDashboardController::class, 'uploadDocuments'])->name('registrations.upload');
    Route::get('/lomba-saya/{registration}/kartu', [PesertaDashboardController::class, 'participantCard'])->name('registrations.card');

    // Jadwal, Pengumuman, Sertifikat, & Profil
    Route::get('/jadwal', [PesertaDashboardController::class, 'schedule'])->name('schedule');
    Route::get('/sertifikat', [PesertaDashboardController::class, 'certificates'])->name('certificates');
    Route::get('/profil', [PesertaDashboardController::class, 'profile'])->name('profile');
    Route::put('/profil', [PesertaDashboardController::class, 'updateProfile'])->name('profile.update');
});
