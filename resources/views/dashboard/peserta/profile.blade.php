@extends('layouts.peserta')

@section('title', 'Profil Saya')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold font-display text-slate-900">Profil Saya</h1>
            <p class="text-sm text-slate-500 mt-1">
                Data ini digunakan otomatis untuk pendaftaran lomba, Kartu Peserta, dan E-Sertifikat resmi.
            </p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $user->isParticipantProfileComplete() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-800' }}">
            {{ $user->isParticipantProfileComplete() ? '✓ Profil Lengkap' : '● Profil Belum Lengkap' }}
        </span>
    </div>

    <form method="POST" action="{{ route('peserta.profile.update') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        @csrf
        @method('PUT')

        {{-- Biodata Utama --}}
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6 space-y-5">
            <h2 class="text-base font-bold font-display text-slate-900 border-b border-slate-100 pb-3">Biodata Siswa & Asal Sekolah</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email Akun</label>
                    <input type="email" id="email" value="{{ $user->email }}" disabled
                           class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp Aktif <span class="text-red-500">*</span></label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required
                           placeholder="0812xxxxxxxx"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label for="nisn" class="block text-xs font-semibold text-slate-700 mb-1.5">NISN / NIM</label>
                    <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $user->nisn) }}"
                           placeholder="Contoh: 0071234567"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label for="gender" class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Kelamin</label>
                    <select id="gender" name="gender"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('gender', $user->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $user->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label for="school_name" class="block text-xs font-semibold text-slate-700 mb-1.5">Asal Sekolah / Perguruan Tinggi <span class="text-red-500">*</span></label>
                    <input type="text" id="school_name" name="school_name" value="{{ old('school_name', $user->school_name) }}" required
                           placeholder="Contoh: SMA N 1 Laguboti"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label for="education_level" class="block text-xs font-semibold text-slate-700 mb-1.5">Jenjang Pendidikan <span class="text-red-500">*</span></label>
                    <select id="education_level" name="education_level" required
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                        @foreach (['SD' => 'SD / Sederajat', 'SMP' => 'SMP / Sederajat', 'SMA' => 'SMA', 'SMK' => 'SMK', 'Lainnya' => 'Lainnya / Mahasiswa'] as $val => $label)
                            <option value="{{ $val }}" {{ old('education_level', $user->education_level) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="grade" class="block text-xs font-semibold text-slate-700 mb-1.5">Kelas / Semester</label>
                    <input type="text" id="grade" name="grade" value="{{ old('grade', $user->grade) }}"
                           placeholder="Contoh: Kelas XI"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label for="city" class="block text-xs font-semibold text-slate-700 mb-1.5">Kabupaten / Kota</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                           placeholder="Contoh: Kabupaten Toba"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label for="province" class="block text-xs font-semibold text-slate-700 mb-1.5">Provinsi</label>
                    <input type="text" id="province" name="province" value="{{ old('province', $user->province) }}"
                           placeholder="Contoh: Sumatera Utara"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- Keamanan & Simpan --}}
        <div class="lg:col-span-4 space-y-5">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6 space-y-4">
                <h2 class="text-base font-bold font-display text-slate-900 border-b border-slate-100 pb-3">Ubah Kata Sandi</h2>
                <p class="text-xs text-slate-500">Kosongkan bila tidak ingin mengganti kata sandi saat ini.</p>

                <div>
                    <label for="new_password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Minimal 6 karakter"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi kata sandi baru"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm shadow-blue-600/20 transition cursor-pointer">
                    Simpan Perubahan Profil
                </button>
            </div>
        </div>
    </form>
@endsection
