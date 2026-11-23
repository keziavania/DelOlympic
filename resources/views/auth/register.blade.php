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
                        'fade-in-up': 'fadeInUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards',
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

<body class="min-h-screen antialiased text-slate-800 bg-[#fafbfe] selection:bg-blue-600 selection:text-white">

    @php
        // Cek role yang ditentukan dari URL / old input
        $initialRole = old('role', $selectedRole ?? request('role'));
        $showFormInitially = ($initialRole !== null && in_array($initialRole, ['peserta', 'penyelenggara'])) || $errors->any();
        $activeRole = in_array($initialRole, ['peserta', 'penyelenggara']) ? $initialRole : 'peserta';
    @endphp

    {{-- ========================================================================= --}}
    {{-- TAMPILAN 1: PILIHAN PERAN (PERSIS GAMBAR REFERENSI DENGAN DESAIN DEL OLYMPIC) --}}
    {{-- ========================================================================= --}}
    <div id="view-role-selection" class="{{ $showFormInitially ? 'hidden' : 'flex' }} min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        
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
                    Silakan pilih peran untuk melanjutkan
                </p>
            </div>

            {{-- 2 Kartu Peran (Peserta & Penyelenggara) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 max-w-3xl mx-auto">
                
                {{-- KARTU 1: PESERTA --}}
                <div class="role-card bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-sm flex flex-col justify-between text-center relative overflow-hidden group">
                    <div class="flex flex-col items-center">
                        {{-- Icon Peserta --}}
                        <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
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
                                class="w-full py-3.5 px-6 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md shadow-blue-600/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                            <span>Daftar sebagai Peserta</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>

                        {{-- Tombol Sekunder: Masuk ke Akun (sesuai referensi tombol abu-abu tua) --}}
                        <a href="{{ route('login') }}"
                           class="w-full inline-flex items-center justify-center py-3.5 px-6 rounded-2xl bg-[#525f7f] hover:bg-[#434e6b] text-white font-semibold text-sm shadow-sm transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            Masuk ke Akun
                        </a>
                    </div>
                </div>

                {{-- KARTU 2: PENYELENGGARA (Dengan aksen border tegas sesuai gambar referensi) --}}
                <div class="role-card bg-white rounded-3xl p-8 sm:p-10 border-2 border-blue-600 shadow-sm flex flex-col justify-between text-center relative overflow-hidden group">
                    <div class="flex flex-col items-center">
                        {{-- Icon Penyelenggara --}}
                        <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
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

                    {{-- Tombol Aksi --}}
                    <div class="space-y-3 w-full">
                        {{-- Tombol Utama: Daftar sebagai Penyelenggara --}}
                        <button type="button"
                                onclick="selectRoleAndOpenForm('penyelenggara')"
                                class="w-full py-3.5 px-6 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md shadow-blue-600/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                            <span>Daftar sebagai Penyelenggara</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>

                        {{-- Tombol Sekunder: Masuk ke Akun (sesuai referensi tombol abu-abu tua) --}}
                        <a href="{{ route('login') }}"
                           class="w-full inline-flex items-center justify-center py-3.5 px-6 rounded-2xl bg-[#525f7f] hover:bg-[#434e6b] text-white font-semibold text-sm shadow-sm transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            Masuk ke Akun
                        </a>
                    </div>
                </div>

            </div>

            {{-- Footer Tautan Kembali --}}
            <div class="mt-12 text-center">
                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Halaman Beranda
                </a>
            </div>

        </div>
    </div>


    {{-- ========================================================================= --}}
    {{-- TAMPILAN 2: FORMULIR PENDAFTARAN (MENGIKUTI DESAIN LOGIN DARI TEMAN)     --}}
    {{-- ========================================================================= --}}
    <div id="view-registration-form" class="{{ $showFormInitially ? 'flex' : 'hidden' }} min-h-screen">
        
        {{-- ========== SISI KIRI: Foto Kampus + Branding (Persis Login) ========== --}}
        <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 bg-campus relative overflow-hidden">
            {{-- Overlay gelap --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#0b1c3d]/85 via-[#1660eb]/55 to-[#0b1c3d]/75"></div>

            {{-- Konten branding --}}
            <div class="relative z-10 flex flex-col justify-between p-10 xl:p-14 w-full text-white">

                {{-- Logo atas --}}
                <div>
                    <a href="{{ url('/') }}" class="inline-flex items-center group">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Logo Del Olympic"
                             class="h-12 w-auto object-contain brightness-0 invert transition-transform group-hover:scale-105">
                    </a>
                </div>

                {{-- Teks tengah --}}
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Pendaftaran Akun Del Olympic
                    </div>

                    <h1 class="text-4xl xl:text-5xl font-bold font-display leading-tight">
                        Mulai Langkah<br>
                        Juaramu di <span class="text-blue-300">Del Olympic</span>
                    </h1>

                    <p class="text-blue-100/90 text-lg leading-relaxed max-w-md">
                        Bergabunglah dengan ribuan talenta muda di kompetisi olimpiade akademik bergengsi Institut Teknologi Del.
                    </p>

                    {{-- Panduan Role Singkat --}}
                    <div class="grid grid-cols-2 gap-4 pt-4 max-w-md">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/15">
                            <div class="text-blue-300 text-xs font-semibold uppercase tracking-wider">Peran Peserta</div>
                            <div class="text-white text-sm font-medium mt-1">Daftar lomba, kirim karya, dan raih sertifikat & medali.</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/15">
                            <div class="text-blue-300 text-xs font-semibold uppercase tracking-wider">Peran Penyelenggara</div>
                            <div class="text-white text-sm font-medium mt-1">Kelola ajang kompetisi, verifikasi berkas, dan umumkan pemenang.</div>
                        </div>
                    </div>
                </div>

                {{-- Footer kiri --}}
                <div class="text-blue-200/70 text-sm">
                    © {{ date('Y') }} Del Olympic — Institut Teknologi Del
                </div>
            </div>
        </div>

        {{-- ========== SISI KANAN: Formulir Pendaftaran ========== --}}
        <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center min-h-screen bg-slate-50 px-4 py-10 sm:px-8">
            <div class="w-full max-w-md animate-fade-in-up">

                {{-- Tombol kembali ke pemilihan peran --}}
                <div class="mb-4">
                    <button type="button"
                            onclick="showRoleSelection()"
                            class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 hover:text-blue-600 transition group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Ganti Pilihan Peran</span>
                    </button>
                </div>

                {{-- Logo mobile (hanya tampil di bawah lg) --}}
                <div class="flex justify-center mb-6 lg:hidden">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Logo Del Olympic"
                             class="h-12 w-auto object-contain">
                    </a>
                </div>

                {{-- Card Pendaftaran --}}
                <div class="bg-white rounded-3xl px-8 py-9 sm:px-10 register-card register-card-anim">

                    {{-- Header form --}}
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-2xl sm:text-3xl font-bold font-display text-slate-900">
                                Buat Akun Baru
                            </h2>
                        </div>
                        <p class="text-slate-500 text-sm">
                            Lengkapi informasi data Anda untuk mendaftar.
                        </p>
                    </div>

                    {{-- Switcher Role Pill di dalam Form --}}
                    <div class="mb-6 p-1.5 bg-slate-100 rounded-2xl flex items-center gap-1 border border-slate-200/80">
                        <button type="button"
                                id="tab-peserta"
                                onclick="setRoleForm('peserta')"
                                class="w-1/2 py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 flex items-center justify-center gap-1.5 {{ $activeRole === 'peserta' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Peserta</span>
                        </button>
                        
                        <button type="button"
                                id="tab-penyelenggara"
                                onclick="setRoleForm('penyelenggara')"
                                class="w-1/2 py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 flex items-center justify-center gap-1.5 {{ $activeRole === 'penyelenggara' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span>Penyelenggara</span>
                        </button>
                    </div>

                    {{-- Informasi Role Yang Dipilih --}}
                    <div id="role-info-peserta" class="{{ $activeRole === 'peserta' ? 'block' : 'hidden' }} mb-5 p-3.5 bg-blue-50 border border-blue-100 rounded-2xl text-xs text-blue-800">
                        <div class="flex items-center gap-2 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                            <span>Mendaftar sebagai Peserta Lomba</span>
                        </div>
                        <p class="mt-1 text-blue-700/80 leading-relaxed">
                            Akun ini digunakan untuk mendaftar olimpiade, upload berkas, dan melihat sertifikat juara.
                        </p>
                    </div>

                    <div id="role-info-penyelenggara" class="{{ $activeRole === 'penyelenggara' ? 'block' : 'hidden' }} mb-5 p-3.5 bg-indigo-50 border border-indigo-100 rounded-2xl text-xs text-indigo-800">
                        <div class="flex items-center gap-2 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-indigo-600"></span>
                            <span>Mendaftar sebagai Penyelenggara</span>
                        </div>
                        <p class="mt-1 text-indigo-700/80 leading-relaxed">
                            Akun ini memiliki hak akses untuk mempublikasikan kompetisi baru dan memvalidasi peserta.
                        </p>
                    </div>

                    {{-- ===== ALERT: Pesan Error Validasi Umum ===== --}}
                    @if ($errors->any())
                        <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3.5 text-sm">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-xs space-y-1">
                                <span class="font-semibold block text-red-900">Periksa kesalahan input:</span>
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
                          class="space-y-4"
                          novalidate>
                        @csrf

                        {{-- Hidden field untuk role --}}
                        <input type="hidden" name="role" id="input-role" value="{{ $activeRole }}">

                        {{-- ======= FIELD NAMA ======= --}}
                        <div>
                            <label for="name"
                                   id="label-name"
                                   class="block text-sm font-semibold text-slate-700 mb-1.5">
                                {{ $activeRole === 'penyelenggara' ? 'Nama Penyelenggara / Organisasi' : 'Nama Lengkap Peserta' }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    autocomplete="name"
                                    value="{{ old('name') }}"
                                    required
                                    placeholder="{{ $activeRole === 'penyelenggara' ? 'Contoh: Himpunan Mahasiswa Informatika' : 'Contoh: Budi Santoso' }}"
                                    class="input-field w-full pl-10 pr-4 py-3 rounded-xl border
                                           {{ $errors->has('name') ? 'border-red-400 bg-red-50 text-red-900' : 'border-slate-200 bg-slate-50 text-slate-900' }}
                                           text-sm placeholder-slate-400
                                           focus:border-blue-500 focus:bg-white
                                           transition duration-150"
                                >
                            </div>
                            @error('name')
                                <p class="mt-1.5 flex items-center gap-1.5 text-red-600 text-xs font-medium">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ======= FIELD EMAIL ======= --}}
                        <div>
                            <label for="email"
                                   class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
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
                                    class="input-field w-full pl-10 pr-4 py-3 rounded-xl border
                                           {{ $errors->has('email') ? 'border-red-400 bg-red-50 text-red-900' : 'border-slate-200 bg-slate-50 text-slate-900' }}
                                           text-sm placeholder-slate-400
                                           focus:border-blue-500 focus:bg-white
                                           transition duration-150"
                                >
                            </div>
                            @error('email')
                                <p class="mt-1.5 flex items-center gap-1.5 text-red-600 text-xs font-medium">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ======= FIELD KATA SANDI ======= --}}
                        <div>
                            <label for="password"
                                   class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    placeholder="Minimal 6 karakter"
                                    oninput="checkPasswordStrength(this.value)"
                                    class="input-field w-full pl-10 pr-11 py-3 rounded-xl border
                                           {{ $errors->has('password') ? 'border-red-400 bg-red-50 text-red-900' : 'border-slate-200 bg-slate-50 text-slate-900' }}
                                           text-sm placeholder-slate-400
                                           focus:border-blue-500 focus:bg-white
                                           transition duration-150"
                                >
                                <button
                                    type="button"
                                    onclick="togglePasswordVisibility('password', 'icon-eye-1', 'icon-eye-off-1')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition"
                                    aria-label="Tampilkan / sembunyikan kata sandi">
                                    <svg id="icon-eye-1" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="icon-eye-off-1" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            
                            {{-- Indikator Kekuatan Password --}}
                            <div class="mt-2">
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div id="strength-meter" class="strength-bar h-full w-0 bg-slate-300"></div>
                                </div>
                                <p id="strength-text" class="text-[11px] text-slate-400 mt-1">Kekuatan kata sandi: belum diisi</p>
                            </div>

                            @error('password')
                                <p class="mt-1.5 flex items-center gap-1.5 text-red-600 text-xs font-medium">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ======= FIELD KONFIRMASI KATA SANDI ======= --}}
                        <div>
                            <label for="password_confirmation"
                                   class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Ulangi Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    placeholder="Ulangi kata sandi Anda"
                                    oninput="checkPasswordMatch()"
                                    class="input-field w-full pl-10 pr-11 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 text-sm placeholder-slate-400 focus:border-blue-500 focus:bg-white transition duration-150"
                                >
                                <button
                                    type="button"
                                    onclick="togglePasswordVisibility('password_confirmation', 'icon-eye-2', 'icon-eye-off-2')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition"
                                    aria-label="Tampilkan / sembunyikan konfirmasi kata sandi">
                                    <svg id="icon-eye-2" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="icon-eye-off-2" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <p id="match-text" class="text-[11px] mt-1 text-slate-400"></p>
                        </div>

                        {{-- ======= CHECKBOX PERSETUJUAN KETENTUAN ======= --}}
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
                            @error('terms')
                                <p class="mt-1 flex items-center gap-1.5 text-red-600 text-xs font-medium">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ======= TOMBOL SUBMIT DAFTAR ======= --}}
                        <button
                            type="submit"
                            id="btn-submit"
                            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 mt-3
                                   bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                                   text-white text-sm font-semibold rounded-xl
                                   shadow-lg shadow-blue-600/30
                                   transition duration-150 transform hover:-translate-y-0.5 active:translate-y-0
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            {{-- Spinner (tersembunyi saat normal) --}}
                            <svg id="btn-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            <span id="btn-text">Daftar Sekarang</span>
                        </button>

                    </form>

                    {{-- ======= DIVIDER ======= --}}
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white px-3 text-slate-400 font-medium">sudah punya akun?</span>
                        </div>
                    </div>

                    {{-- ======= LINK KE HALAMAN MASUK (LOGIN) ======= --}}
                    <div class="text-center">
                        <p class="text-sm text-slate-600">
                            Sudah memiliki akun?
                            <a href="{{ route('login') }}"
                               class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition">
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

            const tabPeserta       = document.getElementById('tab-peserta');
            const tabPenyelenggara = document.getElementById('tab-penyelenggara');
            const infoPeserta      = document.getElementById('role-info-peserta');
            const infoPenyelenggara= document.getElementById('role-info-penyelenggara');
            const labelName        = document.getElementById('label-name');
            const inputName        = document.getElementById('name');

            if (role === 'penyelenggara') {
                // Update tabs styling
                tabPenyelenggara.className = 'w-1/2 py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 flex items-center justify-center gap-1.5 bg-white text-blue-700 shadow-sm';
                tabPeserta.className       = 'w-1/2 py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900';
                
                // Toggle info cards
                infoPenyelenggara.classList.remove('hidden');
                infoPeserta.classList.add('hidden');

                // Update label & placeholder
                labelName.textContent = 'Nama Penyelenggara / Organisasi';
                inputName.placeholder = 'Contoh: Himpunan Mahasiswa Informatika';
            } else {
                // Update tabs styling
                tabPeserta.className       = 'w-1/2 py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 flex items-center justify-center gap-1.5 bg-white text-blue-700 shadow-sm';
                tabPenyelenggara.className = 'w-1/2 py-2 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-150 flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900';
                
                // Toggle info cards
                infoPeserta.classList.remove('hidden');
                infoPenyelenggara.classList.add('hidden');

                // Update label & placeholder
                labelName.textContent = 'Nama Lengkap Peserta';
                inputName.placeholder = 'Contoh: Budi Santoso';
            }
        }

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
                text.className = 'text-[11px] text-slate-400 mt-1';
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
                text.textContent = 'Kekuatan kata sandi: Lemah (tambahkan angka & huruf besar)';
                text.className = 'text-[11px] text-red-600 mt-1 font-medium';
            } else if (score <= 3) {
                meter.style.width = '66%';
                meter.className = 'strength-bar h-full bg-amber-500';
                text.textContent = 'Kekuatan kata sandi: Cukup baik';
                text.className = 'text-[11px] text-amber-600 mt-1 font-medium';
            } else {
                meter.style.width = '100%';
                meter.className = 'strength-bar h-full bg-emerald-500';
                text.textContent = 'Kekuatan kata sandi: Sangat Kuat & Aman';
                text.className = 'text-[11px] text-emerald-600 mt-1 font-medium';
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
                text.className   = 'text-[11px] mt-1 text-emerald-600 font-medium';
            } else {
                text.textContent = '✗ Kata sandi belum cocok';
                text.className   = 'text-[11px] mt-1 text-red-600 font-medium';
            }
        }

        // ========== Loading State pada Submit Formulir ==========
        document.getElementById('form-register').addEventListener('submit', function (e) {
            const btn     = document.getElementById('btn-submit');
            const spinner = document.getElementById('btn-spinner');
            const text    = document.getElementById('btn-text');

            const name     = document.getElementById('name').value.trim();
            const email    = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const terms    = document.getElementById('terms').checked;

            if (!name || !email || !password || !terms) return; // biarkan browser validasi

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
