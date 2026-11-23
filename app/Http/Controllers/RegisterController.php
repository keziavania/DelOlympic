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
        $role = $request->input('role');

        // Aturan validasi dasar yang berlaku untuk semua
        $rules = [
            'role'     => ['required', 'string', 'in:peserta,penyelenggara'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone'    => ['required', 'string', 'max:30'],
            'terms'    => ['accepted'],
        ];

        // Validasi spesifik berdasarkan peran
        if ($role === 'peserta') {
            $rules['school_name']     = ['required', 'string', 'max:255'];
            $rules['education_level'] = ['required', 'string', 'max:50'];
            $rules['nisn']            = ['nullable', 'string', 'max:20'];
            $rules['gender']          = ['nullable', 'string', 'in:Laki-laki,Perempuan'];
            $rules['grade']           = ['nullable', 'string', 'max:20'];
            $rules['city']            = ['nullable', 'string', 'max:100'];
            $rules['province']        = ['nullable', 'string', 'max:100'];
        } elseif ($role === 'penyelenggara') {
            $rules['institution_name']    = ['required', 'string', 'max:255'];
            $rules['institution_type']    = ['required', 'string', 'max:100'];
            $rules['position']            = ['required', 'string', 'max:100'];
            $rules['institution_address'] = ['required', 'string'];
            $rules['institution_website'] = ['nullable', 'string', 'max:255'];
            $rules['institution_phone']   = ['nullable', 'string', 'max:30'];
            $rules['document_link']       = ['nullable', 'string', 'max:500'];
        }

        // Pesan validasi kustom dalam bahasa Indonesia
        $messages = [
            'role.required'              => 'Silakan pilih peran pendaftaran (Peserta atau Penyelenggara).',
            'role.in'                    => 'Peran yang dipilih tidak valid.',
            'name.required'              => $role === 'penyelenggara' ? 'Nama lengkap penanggung jawab wajib diisi.' : 'Nama lengkap peserta wajib diisi.',
            'name.max'                   => 'Nama maksimal 255 karakter.',
            'email.required'             => 'Alamat email wajib diisi.',
            'email.email'                => 'Format alamat email tidak valid.',
            'email.max'                  => 'Alamat email terlalu panjang.',
            'email.unique'               => 'Alamat email ini sudah terdaftar. Silakan gunakan email lain atau langsung masuk ke akun Anda.',
            'password.required'          => 'Kata sandi wajib diisi.',
            'password.min'               => 'Kata sandi minimal 6 karakter.',
            'password.confirmed'         => 'Konfirmasi kata sandi tidak cocok.',
            'phone.required'             => 'Nomor telepon / WhatsApp aktif wajib diisi.',
            'school_name.required'       => 'Asal sekolah wajib diisi.',
            'education_level.required'   => 'Jenjang pendidikan wajib dipilih.',
            'institution_name.required'  => 'Nama lembaga / institusi penyelenggara wajib diisi.',
            'institution_type.required'  => 'Jenis lembaga wajib dipilih.',
            'position.required'          => 'Jabatan penanggung jawab di institusi wajib diisi.',
            'institution_address.required' => 'Alamat lengkap kantor / institusi wajib diisi.',
            'terms.accepted'             => 'Anda harus menyetujui syarat & ketentuan serta kebijakan privasi Del Olympic.',
        ];

        $validated = $request->validate($rules, $messages);

        // Status akun:
        // - Peserta langsung 'aktif' agar siswa dapat langsung ikut lomba.
        // - Penyelenggara 'menunggu' agar dapat diverifikasi oleh admin Del Olympic terlebih dahulu.
        $statusAkun = $validated['role'] === 'penyelenggara' ? 'menunggu' : 'aktif';

        $userData = [
            'name'        => trim($validated['name']),
            'email'       => strtolower(trim($validated['email'])),
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'],
            'status_akun' => $statusAkun,
            'phone'       => trim($validated['phone']),
        ];

        if ($validated['role'] === 'peserta') {
            $userData['school_name']     = trim($validated['school_name']);
            $userData['education_level'] = trim($validated['education_level']);
            $userData['nisn']            = !empty($validated['nisn']) ? trim($validated['nisn']) : null;
            $userData['gender']          = $validated['gender'] ?? null;
            $userData['grade']           = !empty($validated['grade']) ? trim($validated['grade']) : null;
            $userData['city']            = !empty($validated['city']) ? trim($validated['city']) : null;
            $userData['province']        = !empty($validated['province']) ? trim($validated['province']) : null;
        } else {
            $userData['institution_name']    = trim($validated['institution_name']);
            $userData['institution_type']    = trim($validated['institution_type']);
            $userData['position']            = trim($validated['position']);
            $userData['institution_address'] = trim($validated['institution_address']);
            $userData['institution_website'] = !empty($validated['institution_website']) ? trim($validated['institution_website']) : null;
            $userData['institution_phone']   = !empty($validated['institution_phone']) ? trim($validated['institution_phone']) : null;
            $userData['document_link']       = !empty($validated['document_link']) ? trim($validated['document_link']) : null;
        }

        // Simpan akun ke database
        User::create($userData);

        if ($validated['role'] === 'penyelenggara') {
            return redirect()->route('login')->with(
                'success',
                'Pendaftaran Penyelenggara berhasil dikirim! Akun Anda sedang dalam proses verifikasi tim admin Del Olympic. Harap tunggu konfirmasi sebelum dapat mempublikasikan lomba.'
            );
        }

        return redirect()->route('login')->with(
            'success',
            'Pendaftaran akun Peserta berhasil! Silakan masuk menggunakan email dan kata sandi Anda.'
        );
    }
}
