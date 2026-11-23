<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman pendaftaran akun.
     */
    public function showRegister(Request $request)
    {
        // Jika sudah login, langsung arahkan ke dashboard sesuai role
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin'         => redirect()->route('admin.dashboard'),
                'penyelenggara' => redirect()->route('penyelenggara.dashboard'),
                'peserta'       => redirect()->route('peserta.dashboard'),
                default         => redirect()->route('home'),
            };
        }

        $selectedRole = $request->query('role');
        if (!in_array($selectedRole, ['peserta', 'penyelenggara'])) {
            $selectedRole = null;
        }

        return view('auth.register', compact('selectedRole'));
    }

    /**
     * Proses pendaftaran akun baru.
     */
    public function register(Request $request)
    {
        // Validasi input form pendaftaran
        $validated = $request->validate([
            'role'     => ['required', 'string', 'in:peserta,penyelenggara'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms'    => ['accepted'],
        ], [
            'role.required'      => 'Silakan pilih peran pendaftaran (Peserta atau Penyelenggara).',
            'role.in'            => 'Peran yang dipilih tidak valid.',
            'name.required'      => 'Nama wajib diisi.',
            'name.max'           => 'Nama maksimal 255 karakter.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format alamat email tidak valid.',
            'email.max'          => 'Alamat email terlalu panjang.',
            'email.unique'       => 'Alamat email sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'terms.accepted'     => 'Anda harus menyetujui syarat & ketentuan serta kebijakan privasi Del Olympic.',
        ]);

        // Buat user baru di database
        $user = User::create([
            'name'        => trim($validated['name']),
            'email'       => strtolower(trim($validated['email'])),
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
            'status_akun' => 'aktif',
        ]);

        $roleLabel = $user->role === 'penyelenggara' ? 'Penyelenggara' : 'Peserta';

        return redirect()->route('login')->with(
            'success',
            "Pendaftaran akun {$roleLabel} berhasil! Silakan masuk menggunakan email dan kata sandi Anda."
        );
    }
}
