<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun — Del Olympic</title>

    <!-- Google Fonts: Poppins & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        del: {
                            50:      '#f0f7ff',
                            100:     '#e0effe',
                            200:     '#bae0fd',
                            300:     '#7cc7fb',
                            400:     '#38a8f8',
                            500:     '#0ea5e9',
                            600:     '#0284c7',
                            700:     '#0369a1',
                            800:     '#075985',
                            900:     '#0c4a6e',
                            primary: '#1660eb',
                            dark:    '#0b1c3d',
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.4s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%':   { opacity: '0', transform: 'translateY(16px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, .font-display {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Background parallax feel */
        .bg-campus {
            background-image: url('{{ asset('images/del-campus.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Input focus glow */
        .input-field:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(22, 96, 235, 0.15);
        }

        /* Button loading state */
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        /* Password strength indicator */
        .strength-bar {
            transition: width 0.3s ease, background-color 0.3s ease;
        }

        /* Card shadow */
        .register-card {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        /* Role Card Hover & Glow */
        .role-card {
            transition: all 0.25s ease-in-out;
        }
        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(22, 96, 235, 0.15);
        }

        /* Animated gradient border on card */
        @keyframes borderGlow {
            0%, 100% { box-shadow: 0 20px 60px rgba(22, 96, 235, 0.08), 0 4px 20px rgba(0, 0, 0, 0.08); }
            50%       { box-shadow: 0 20px 60px rgba(22, 96, 235, 0.18), 0 4px 20px rgba(22, 96, 235, 0.12); }
        }
        .register-card-anim {
            animation: borderGlow 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="min-h-screen antialiased text-slate-800 bg-[#fafbfe] selection:bg-blue-600 selection:text-white relative">

    @php
        // Cek role yang ditentukan dari URL / old input
        $initialRole = old('role', $selectedRole ?? request('role'));
        $showFormInitially = ($initialRole !== null && in_array($initialRole, ['peserta', 'penyelenggara'])) || $errors->any();
        $activeRole = in_array($initialRole, ['peserta', 'penyelenggara']) ? $initialRole : 'peserta';
    @endphp

    {{-- ========================================================================= --}}
    {{-- TAMPILAN 1: PILIHAN PERAN (PESERTA & PENYELENGGARA DENGAN DESAIN KONSISTEN) --}}
    {{-- ========================================================================= --}}
    <div id="view-role-selection" class="{{ $showFormInitially ? 'hidden' : 'flex' }} min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        
        {{-- Tombol Kembali di Pojok Atas Kiri (Standar Website Modern) --}}
        <a href="{{ url('/') }}"
           class="fixed top-5 left-5 z-50 inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 hover:text-blue-600 text-xs sm:text-sm font-semibold shadow-md shadow-slate-900/5 border border-slate-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0 group">
            <svg class="w-4 h-4 text-blue-600 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Beranda</span>
        </a>

        {{-- Background aksen melingkar lembut --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-100/60 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-100/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full max-w-4xl mx-auto relative z-10 animate-fade-in-up">
            
            {{-- Header Atas (Logo & Sambutan) --}}
            <div class="text-center mb-10 sm:mb-12">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center group mb-6">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Logo Del Olympic"
                         class="h-12 sm:h-14 w-auto object-contain transition-transform group-hover:scale-105">
                </a>
                
                <h1 class="text-3xl sm:text-4xl font-extrabold font-display text-slate-900 tracking-tight">
                    Selamat Datang
                </h1>
                <p class="mt-2.5 text-base text-slate-500 font-normal">
                    Silakan pilih peran untuk melanjutkan pendaftaran
                </p>
            </div>

            {{-- 2 Kartu Peran (Peserta & Penyelenggara) - BORDER DIBUAT KONSISTEN DUA-DUANYA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 max-w-3xl mx-auto">
                
                {{-- KARTU 1: PESERTA --}}
                <div class="role-card bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 hover:border-blue-500 shadow-sm flex flex-col justify-between text-center relative overflow-hidden group">
                    <div class="flex flex-col items-center">
                        {{-- Icon Peserta --}}
                        <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-xs">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>

                        {{-- Judul Peran --}}
                        <h2 class="text-2xl font-bold font-display text-slate-900 mb-2.5">
                            Peserta
                        </h2>

                        {{-- Deskripsi Peran --}}
                        <p class="text-sm text-slate-500 leading-relaxed max-w-xs mb-8">
                            Daftar sebagai peserta untuk mengikuti olimpiade sains, matematika, kompetisi IT, dan raih prestasi membanggakan.
                        </p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="space-y-3 w-full">
                        {{-- Tombol Utama: Daftar sebagai Peserta --}}
                        <button type="button"
                                onclick="selectRoleAndOpenForm('peserta')"
                                class="w-full py-3.5 px-6 rounded-2xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm shadow-md shadow-blue-600/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer">
                            <span>Daftar sebagai Peserta</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>

                        {{-- Tombol Sekunder: Masuk ke Akun --}}
                        <a href="{{ route('login') }}"
                           class="w-full inline-flex items-center justify-center py-3.5 px-6 rounded-2xl bg-[#525f7f] hover:bg-[#434e6b] text-white font-semibold text-sm shadow-sm transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            Masuk ke Akun
                        </a>
                    </div>
                </div>

                {{-- KARTU 2: PENYELENGGARA (BORDER KONSISTEN PERSIS KARTU PESERTA) --}}
                <div class="role-card bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 hover:border-blue-500 shadow-sm flex flex-col justify-between text-center relative overflow-hidden group">
                    <div class="flex flex-col items-center">
                        {{-- Icon Penyelenggara --}}
                        <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-xs">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>

                        {{-- Judul Peran --}}
                        <h2 class="text-2xl font-bold font-display text-slate-900 mb-2.5">
                            Penyelenggara
                        </h2>

                        {{-- Deskripsi Peran --}}
                        <p class="text-sm text-slate-500 leading-relaxed max-w-xs mb-8">
                            Daftar sebagai penyelenggara untuk membuat ajang lomba, mengelola peserta, memverifikasi data, dan mengumumkan hasil.
                        </p>
                    </div>

                    {{-- Tombol Aksi (Warna Satu Konsisten Biru) --}}
                    <div class="space-y-3 w-full">
                        {{-- Tombol Utama: Daftar sebagai Penyelenggara --}}
                        <button type="button"
                                onclick="selectRoleAndOpenForm('penyelenggara')"
                                class="w-full py-3.5 px-6 rounded-2xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm shadow-md shadow-blue-600/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 cursor-pointer">
                            <span>Daftar sebagai Penyelenggara</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>

                        {{-- Tombol Sekunder: Masuk ke Akun --}}
                        <a href="{{ route('login') }}"
                           class="w-full inline-flex items-center justify-center py-3.5 px-6 rounded-2xl bg-[#525f7f] hover:bg-[#434e6b] text-white font-semibold text-sm shadow-sm transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            Masuk ke Akun
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>


    {{-- ========================================================================= --}}
    {{-- TAMPILAN 2: FORMULIR PENDAFTARAN LENGKAP (PESERTA & PENYELENGGARA)        --}}
    {{-- ========================================================================= --}}
    <div id="view-registration-form" class="{{ $showFormInitially ? 'flex' : 'hidden' }} min-h-screen relative">
        
        {{-- ========== SISI KIRI: Foto Kampus + Branding (Sticky di Layar & Tidak Melorot ke Bawah) ========== --}}
        <div class="hidden lg:block lg:w-1/2 xl:w-2/5 relative">
            <div class="sticky top-0 h-screen w-full bg-campus overflow-hidden flex flex-col justify-between p-8 xl:p-12 text-white">
                {{-- Overlay gelap --}}
                <div class="absolute inset-0 bg-gradient-to-br from-[#0b1c3d]/90 via-[#1660eb]/60 to-[#0b1c3d]/80 pointer-events-none"></div>

                {{-- Baris atas: Logo --}}
                <div class="relative z-10 flex items-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl shadow-sm border border-white/60 group hover:bg-white transition-all transform hover:scale-105">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Logo Del Olympic"
                             class="h-8 w-auto object-contain">
                    </a>
                </div>

                {{-- Teks tengah (Hanya Judul dan Deskripsi Sesuai Permintaan) --}}
                <div class="relative z-10 space-y-4 my-auto py-6">
                    <h1 class="text-3xl xl:text-4xl font-bold font-display leading-tight">
                        Mulai Langkah<br>
                        Juaramu di <span class="text-blue-300">Del Olympic</span>
                    </h1>

                    <p class="text-blue-100/90 text-base leading-relaxed max-w-sm">
                        Bergabunglah dengan ribuan talenta muda di kompetisi olimpiade akademik bergengsi Institut Teknologi Del.
                    </p>
                </div>

                {{-- Footer kiri --}}
                <div class="relative z-10 text-blue-200/70 text-xs">
                    © {{ date('Y') }} Del Olympic — Institut Teknologi Del
                </div>
            </div>
        </div>

        {{-- ========== SISI KANAN: Formulir Pendaftaran ========== --}}
        <div class="w-full lg:w-1/2 xl:w-3/5 flex items-center justify-center min-h-screen bg-slate-50 px-4 py-12 sm:px-8">
            <div class="w-full max-w-xl animate-fade-in-up pt-10 sm:pt-4">

                {{-- Tombol ganti peran di mobile/header card --}}
                <div class="mb-4 flex items-center">
                    <button type="button"
                            onclick="showRoleSelection()"
                            class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 hover:text-blue-600 transition group cursor-pointer">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Ganti Pilihan Peran</span>
                    </button>
                </div>

                {{-- Card Pendaftaran --}}
                <div class="bg-white rounded-3xl px-6 py-8 sm:px-10 sm:py-10 register-card register-card-anim">

                    {{-- Header form --}}
                    <div class="mb-6">
                        <h2 id="form-title" class="text-2xl sm:text-3xl font-bold font-display text-slate-900">
                            {{ $activeRole === 'penyelenggara' ? 'Daftar sebagai Penyelenggara' : 'Daftar sebagai Peserta' }}
                        </h2>
                        <p id="form-subtitle" class="text-slate-500 text-sm mt-1.5">
                            {{ $activeRole === 'penyelenggara' ? 'Lengkapi data lembaga & penanggung jawab untuk verifikasi admin.' : 'Lengkapi biodata lengkap siswa untuk keperluan kartu peserta & sertifikat olimpiade.' }}
                        </p>
                    </div>

                    {{-- ===== ALERT: Pesan Error Validasi Umum ===== --}}
                    @if ($errors->any())
                        <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3.5 text-sm">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-xs space-y-1">
                                <span class="font-semibold block text-red-900">Silakan periksa input form:</span>
                                @foreach ($errors->all() as $error)
                                    <div>• {{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- ===== FORM REGISTRASI ===== --}}
                    <form id="form-register"
                          method="POST"
                          action="{{ route('register.post') }}"
                          class="space-y-5"
                          novalidate>
                        @csrf

                        {{-- Hidden field untuk role --}}
                        <input type="hidden" name="role" id="input-role" value="{{ $activeRole }}">

                        {{-- ========================================================================= --}}
                        {{-- BLOK 1: BIDANG KHUSUS PESERTA (BIODATA LENGKAP SISWA OLIMPIADE)          --}}
                        {{-- ========================================================================= --}}
                        <div id="fields-peserta" class="{{ $activeRole === 'peserta' ? 'block' : 'hidden' }} space-y-4">
                            
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">1. Biodata Siswa</h3>
                            </div>

                            {{-- Nama Lengkap Siswa --}}
                            <div>
                                <label for="name_peserta" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Nama Lengkap Siswa <span class="text-red-500">*</span>
                                </label>
                                <input
                                    id="name_peserta"
                                    name="name"
                                    type="text"
                                    value="{{ old('role') === 'peserta' || $activeRole === 'peserta' ? old('name') : '' }}"
                                    placeholder="Contoh: Budi Santoso (sesuai Ijazah/NISN)"
                                    class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                >
                            </div>

                            {{-- NISN & Jenis Kelamin --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="nisn" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        NISN (10 Digit) <span class="text-slate-400 text-[11px] font-normal">(Opsional)</span>
                                    </label>
                                    <input
                                        id="nisn"
                                        name="nisn"
                                        type="text"
                                        maxlength="15"
                                        value="{{ old('nisn') }}"
                                        placeholder="0071234567"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                                <div>
                                    <label for="gender" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Jenis Kelamin
                                    </label>
                                    <select
                                        id="gender"
                                        name="gender"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:border-blue-500 focus:bg-white transition"
                                    >
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="border-b border-slate-100 pb-2 pt-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">2. Data Asal Sekolah</h3>
                            </div>

                            {{-- Asal Sekolah & Jenjang --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label for="school_name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Asal Sekolah <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="school_name"
                                        name="school_name"
                                        type="text"
                                        value="{{ old('school_name') }}"
                                        placeholder="Contoh: SDN 1 Laguboti / SMPN 1 Balige / SMAN 1 Balige"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                                <div>
                                    <label for="education_level" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Jenjang <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="education_level"
                                        name="education_level"
                                        class="input-field w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:border-blue-500 focus:bg-white transition cursor-pointer"
                                    >
                                        <option value="SD" {{ old('education_level') === 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                                        <option value="SMP" {{ old('education_level') === 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                                        <option value="SMA" {{ old('education_level') === 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="SMK" {{ old('education_level') === 'SMK' ? 'selected' : '' }}>SMK</option>
                                        <option value="Lainnya" {{ old('education_level') === 'Lainnya' ? 'selected' : '' }}>Lainnya / Mahasiswa</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Kelas & Kota/Kabupaten --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="grade" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Kelas
                                    </label>
                                    <input
                                        id="grade"
                                        name="grade"
                                        type="text"
                                        value="{{ old('grade') }}"
                                        placeholder="Contoh: Kelas X / XI / XII"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                                <div>
                                    <label for="city_peserta" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Kabupaten / Kota Sekolah
                                    </label>
                                    <input
                                        id="city_peserta"
                                        name="city"
                                        type="text"
                                        value="{{ old('city') }}"
                                        placeholder="Contoh: Kab. Toba / Kota Medan"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                            </div>
                        </div>


                        {{-- ========================================================================= --}}
                        {{-- BLOK 2: BIDANG KHUSUS PENYELENGGARA (DATA LENGKAP INSTITUSI UNTUK ADMIN) --}}
                        {{-- ========================================================================= --}}
                        <div id="fields-penyelenggara" class="{{ $activeRole === 'penyelenggara' ? 'block' : 'hidden' }} space-y-4">
                            
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">1. Data Legalitas Lembaga / Institusi</h3>
                            </div>

                            {{-- Nama Lembaga & Jenis Institusi --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label for="institution_name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Nama Lembaga / Penyelenggara <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="institution_name"
                                        name="institution_name"
                                        type="text"
                                        value="{{ old('institution_name') }}"
                                        placeholder="Contoh: Fakultas Informatika IT Del / POSI Indonesia"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                                <div>
                                    <label for="institution_type" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Jenis Lembaga <span class="text-red-500">*</span>
                                    </label>
                                    <select
                                        id="institution_type"
                                        name="institution_type"
                                        class="input-field w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:border-blue-500 focus:bg-white transition"
                                    >
                                        <option value="Perguruan Tinggi" {{ old('institution_type') === 'Perguruan Tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                                        <option value="Sekolah / Yayasan" {{ old('institution_type') === 'Sekolah / Yayasan' ? 'selected' : '' }}>Sekolah / Yayasan</option>
                                        <option value="Lembaga Olimpiade Resmi" {{ old('institution_type') === 'Lembaga Olimpiade Resmi' ? 'selected' : '' }}>Lembaga Olimpiade Resmi</option>
                                        <option value="Organisasi Pendidikan" {{ old('institution_type') === 'Organisasi Pendidikan' ? 'selected' : '' }}>Organisasi Pendidikan</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Alamat Kantor / Kampus --}}
                            <div>
                                <label for="institution_address" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Alamat Kantor / Kampus Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="institution_address"
                                    name="institution_address"
                                    rows="2"
                                    placeholder="Jl. Sisingamangaraja, Sitoluama, Laguboti, Toba, Sumatera Utara"
                                    class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                >{{ old('institution_address') }}</textarea>
                            </div>

                            {{-- Website Resmi & Link Dokumen Legalitas --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="institution_website" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Website / Tautan Media Sosial Resmi
                                    </label>
                                    <input
                                        id="institution_website"
                                        name="institution_website"
                                        type="url"
                                        value="{{ old('institution_website') }}"
                                        placeholder="https://del.ac.id"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                                <div>
                                    <label for="document_link" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Tautan SK / Dokumen Legalitas <span class="text-slate-400 text-[11px] font-normal">(Drive / PDF)</span>
                                    </label>
                                    <input
                                        id="document_link"
                                        name="document_link"
                                        type="url"
                                        value="{{ old('document_link') }}"
                                        placeholder="https://drive.google.com/..."
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                            </div>

                            <div class="border-b border-slate-100 pb-2 pt-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">2. Data Penanggung Jawab</h3>
                            </div>

                            {{-- Nama Penanggung Jawab & Jabatan --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="name_penyelenggara" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Nama Penanggung Jawab <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="name_penyelenggara"
                                        name="name_organizer"
                                        type="text"
                                        value="{{ old('role') === 'penyelenggara' ? old('name') : '' }}"
                                        placeholder="Contoh: Dr. Ir. Johannes Saragih, M.Kom"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                                <div>
                                    <label for="position" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Jabatan di Institusi <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        id="position"
                                        name="position"
                                        type="text"
                                        value="{{ old('position') }}"
                                        placeholder="Contoh: Dosen Pembina / Ketua Pelaksana"
                                        class="input-field w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                </div>
                            </div>

                        </div>


                        {{-- ========================================================================= --}}
                        {{-- BLOK 3: KONTAK & AKUN LOGIN (BERLAKU UNTUK KEDUA PERAN)                   --}}
                        {{-- ========================================================================= --}}
                        <div class="border-b border-slate-100 pb-2 pt-1">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                <span id="section-contact-title">3. Kontak & Kredensial Akun</span>
                            </h3>
                        </div>

                        {{-- Nomor Telepon / WhatsApp --}}
                        <div>
                            <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Nomor WhatsApp / Telepon Aktif <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    required
                                    placeholder="081234567890"
                                    class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                >
                            </div>
                        </div>

                        {{-- Alamat Email --}}
                        <div>
                            <label for="email" id="label-email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                {{ $activeRole === 'penyelenggara' ? 'Alamat Email Resmi Lembaga / Penyelenggara' : 'Alamat Email Aktif' }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    autocomplete="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="nama@example.com"
                                    class="input-field w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                >
                            </div>
                        </div>

                        {{-- Kata Sandi & Konfirmasi Kata Sandi --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Kata Sandi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="new-password"
                                        required
                                        placeholder="Min. 6 karakter"
                                        oninput="checkPasswordStrength(this.value)"
                                        class="input-field w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                    <button
                                        type="button"
                                        onclick="togglePasswordVisibility('password', 'icon-eye-1', 'icon-eye-off-1')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                        <svg id="icon-eye-1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg id="icon-eye-off-1" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Konfirmasi Sandi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        autocomplete="new-password"
                                        required
                                        placeholder="Ulangi kata sandi"
                                        oninput="checkPasswordMatch()"
                                        class="input-field w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition"
                                    >
                                    <button
                                        type="button"
                                        onclick="togglePasswordVisibility('password_confirmation', 'icon-eye-2', 'icon-eye-off-2')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                        <svg id="icon-eye-2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg id="icon-eye-off-2" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Indikator Sandi --}}
                        <div class="space-y-1">
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div id="strength-meter" class="strength-bar h-full w-0 bg-slate-300"></div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p id="strength-text" class="text-[11px] text-slate-400">Kekuatan kata sandi: belum diisi</p>
                                <p id="match-text" class="text-[11px] text-slate-400"></p>
                            </div>
                        </div>

                        {{-- Checkbox Persetujuan --}}
                        <div class="pt-1">
                            <label class="flex items-start gap-2.5 cursor-pointer group select-none">
                                <input
                                    id="terms"
                                    name="terms"
                                    type="checkbox"
                                    value="1"
                                    {{ old('terms') ? 'checked' : '' }}
                                    required
                                    class="w-4 h-4 mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500 focus:ring-2 cursor-pointer accent-blue-600 flex-shrink-0"
                                >
                                <span class="text-xs text-slate-600 leading-snug group-hover:text-slate-800 transition">
                                    Saya menyetujui <span class="text-blue-600 font-medium">Syarat & Ketentuan</span> serta <span class="text-blue-600 font-medium">Kebijakan Privasi</span> kompetisi Del Olympic.
                                </span>
                            </label>
                        </div>

                        {{-- Tombol Submit Daftar (Konsisten Satu Warna Biru) --}}
                        <button
                            type="submit"
                            id="btn-submit"
                            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 mt-4
                                   bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                                   text-white text-sm font-semibold rounded-xl
                                   shadow-lg shadow-blue-600/25
                                   transition duration-150 transform hover:-translate-y-0.5 active:translate-y-0
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer">
                            <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            <span id="btn-text">Daftar Sekarang</span>
                        </button>

                    </form>

                    {{-- ======= DIVIDER BERSIH (HAPUS PERTANYAAN ABU-ABU GANDA) ======= --}}
                    <div class="w-full border-t border-slate-100 my-6"></div>

                    {{-- ======= LINK KE HALAMAN MASUK (LOGIN) ======= --}}
                    <div class="text-center">
                        <p class="text-sm text-slate-600">
                            Sudah memiliki akun?
                            <a href="{{ route('login') }}"
                               class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition ml-1">
                                Masuk ke Akun Anda
                            </a>
                        </p>
                    </div>

                </div>

                {{-- Copyright mobile --}}
                <p class="mt-6 text-center text-xs text-slate-400 lg:hidden">
                    © {{ date('Y') }} Del Olympic — Institut Teknologi Del
                </p>

            </div>
        </div>

    </div>

    {{-- ===================== JAVASCRIPT ===================== --}}
    <script>
        // ========== Manajemen Tampilan (Role Selection vs Registration Form) ==========
        function selectRoleAndOpenForm(role) {
            setRoleForm(role);
            document.getElementById('view-role-selection').classList.add('hidden');
            document.getElementById('view-role-selection').classList.remove('flex');

            const formView = document.getElementById('view-registration-form');
            formView.classList.remove('hidden');
            formView.classList.add('flex');

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showRoleSelection() {
            const formView = document.getElementById('view-registration-form');
            formView.classList.add('hidden');
            formView.classList.remove('flex');

            const roleView = document.getElementById('view-role-selection');
            roleView.classList.remove('hidden');
            roleView.classList.add('flex');

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function setRoleForm(role) {
            document.getElementById('input-role').value = role;

            const formTitle           = document.getElementById('form-title');
            const formSubtitle        = document.getElementById('form-subtitle');
            const fieldsPeserta       = document.getElementById('fields-peserta');
            const fieldsPenyelenggara = document.getElementById('fields-penyelenggara');
            const labelEmail          = document.getElementById('label-email');
            const namePesertaInput    = document.getElementById('name_peserta');
            const nameOrgInput        = document.getElementById('name_penyelenggara');

            if (role === 'penyelenggara') {
                if (formTitle) formTitle.textContent = 'Daftar sebagai Penyelenggara';
                if (formSubtitle) formSubtitle.textContent = 'Lengkapi data lembaga & penanggung jawab untuk verifikasi admin.';

                fieldsPenyelenggara.classList.remove('hidden');
                fieldsPeserta.classList.add('hidden');

                if (labelEmail) labelEmail.innerHTML = 'Alamat Email Resmi Lembaga / Penyelenggara <span class="text-red-500">*</span>';

                // Sinkronkan nama jika diisi
                if (nameOrgInput) {
                    nameOrgInput.name = 'name';
                    if (namePesertaInput) namePesertaInput.name = 'name_peserta_temp';
                }
            } else {
                if (formTitle) formTitle.textContent = 'Daftar sebagai Peserta';
                if (formSubtitle) formSubtitle.textContent = 'Lengkapi biodata lengkap siswa untuk keperluan kartu peserta & sertifikat olimpiade.';

                fieldsPeserta.classList.remove('hidden');
                fieldsPenyelenggara.classList.add('hidden');

                if (labelEmail) labelEmail.innerHTML = 'Alamat Email Aktif <span class="text-red-500">*</span>';

                if (namePesertaInput) {
                    namePesertaInput.name = 'name';
                    if (nameOrgInput) nameOrgInput.name = 'name_organizer_temp';
                }
            }
        }

        // Inisialisasi awal role
        document.addEventListener('DOMContentLoaded', function() {
            setRoleForm('{{ $activeRole }}');
        });

        // ========== Toggle Show/Hide Password ==========
        function togglePasswordVisibility(inputId, eyeId, eyeOffId) {
            const input    = document.getElementById(inputId);
            const iconShow = document.getElementById(eyeId);
            const iconHide = document.getElementById(eyeOffId);

            if (input.type === 'password') {
                input.type = 'text';
                iconShow.classList.add('hidden');
                iconHide.classList.remove('hidden');
            } else {
                input.type = 'password';
                iconShow.classList.remove('hidden');
                iconHide.classList.add('hidden');
            }
        }

        // ========== Cek Kekuatan Password Dinamis ==========
        function checkPasswordStrength(password) {
            const meter = document.getElementById('strength-meter');
            const text  = document.getElementById('strength-text');

            if (!password) {
                meter.style.width = '0%';
                meter.className = 'strength-bar h-full w-0 bg-slate-300';
                text.textContent = 'Kekuatan kata sandi: belum diisi';
                text.className = 'text-[11px] text-slate-400';
                return;
            }

            let score = 0;
            if (password.length >= 6) score++;
            if (password.length >= 8) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;

            if (score <= 2) {
                meter.style.width = '33%';
                meter.className = 'strength-bar h-full bg-red-500';
                text.textContent = 'Kekuatan kata sandi: Lemah (tambahkan angka & huruf)';
                text.className = 'text-[11px] text-red-600 font-medium';
            } else if (score <= 3) {
                meter.style.width = '66%';
                meter.className = 'strength-bar h-full bg-amber-500';
                text.textContent = 'Kekuatan kata sandi: Cukup baik';
                text.className = 'text-[11px] text-amber-600 font-medium';
            } else {
                meter.style.width = '100%';
                meter.className = 'strength-bar h-full bg-emerald-500';
                text.textContent = 'Kekuatan kata sandi: Sangat Kuat & Aman';
                text.className = 'text-[11px] text-emerald-600 font-medium';
            }

            checkPasswordMatch();
        }

        // ========== Cek Kecocokan Konfirmasi Password ==========
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirm  = document.getElementById('password_confirmation').value;
            const text     = document.getElementById('match-text');

            if (!confirm) {
                text.textContent = '';
                return;
            }

            if (password === confirm) {
                text.textContent = '✓ Kata sandi cocok';
                text.className   = 'text-[11px] text-emerald-600 font-medium';
            } else {
                text.textContent = '✗ Kata sandi belum cocok';
                text.className   = 'text-[11px] text-red-600 font-medium';
            }
        }

        // ========== Loading State pada Submit Formulir ==========
        document.getElementById('form-register').addEventListener('submit', function (e) {
            const btn     = document.getElementById('btn-submit');
            const spinner = document.getElementById('btn-spinner');
            const text    = document.getElementById('btn-text');

            // Aktifkan state loading
            btn.classList.add('btn-loading');
            spinner.classList.remove('hidden');
            text.textContent = 'Mendaftarkan akun...';
        });

        // Inisialisasi awal jika ada error
        @if ($errors->any())
            const firstErrorField = document.querySelector('input.border-red-400');
            if (firstErrorField) firstErrorField.focus();
        @endif
    </script>
</body>
</html>
