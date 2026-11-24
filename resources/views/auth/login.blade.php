<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Del Olympic</title>

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
                        'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%':   { opacity: '0', transform: 'translateY(20px)' },
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
        .login-card {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12), 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Animated gradient border on card */
        @keyframes borderGlow {
            0%, 100% { box-shadow: 0 20px 60px rgba(22, 96, 235, 0.08), 0 4px 20px rgba(0, 0, 0, 0.08); }
            50%       { box-shadow: 0 20px 60px rgba(22, 96, 235, 0.18), 0 4px 20px rgba(22, 96, 235, 0.12); }
        }
        .login-card-anim {
            animation: borderGlow 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="min-h-screen antialiased text-slate-800 selection:bg-blue-600 selection:text-white relative">

    {{-- ===================== BACKGROUND SPLIT ===================== --}}
    <div class="min-h-screen flex relative">

        {{-- ========== SISI KIRI: Foto Kampus + Branding (Sticky di Layar & Tidak Bergerak Saat Scroll) ========== --}}
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

                {{-- Teks tengah (Proporsional & Selalu di Tengah Layar) --}}
                <div class="relative z-10 space-y-4 my-auto py-6">
                    <h1 class="text-3xl xl:text-4xl font-bold font-display leading-tight">
                        Selamat Datang<br>
                        di <span class="text-blue-300">Del Olympic</span>
                    </h1>

                    <p class="text-blue-100/90 text-base leading-relaxed max-w-sm">
                        Platform manajemen olimpiade resmi Institut Teknologi Del. 
                        Kelola kompetisi, pantau peserta, dan raih prestasi terbaik bersama kami.
                    </p>
                </div>

                {{-- Footer kiri --}}
                <div class="relative z-10 text-blue-200/70 text-xs">
                    © {{ date('Y') }} Del Olympic — Institut Teknologi Del
                </div>
            </div>
        </div>

        {{-- ========== SISI KANAN: Form Login ========== --}}
        <div class="w-full lg:w-1/2 xl:w-3/5 flex items-center justify-center min-h-screen bg-slate-50 px-4 py-12 sm:px-8">
            <div class="w-full max-w-md animate-fade-in-up">

                {{-- Tombol Kembali di atas card --}}
                <div class="mb-4 flex items-center">
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-slate-500 hover:text-blue-600 transition group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>

                {{-- Logo mobile (hanya tampil di bawah lg) --}}
                <div class="flex justify-center mb-8 lg:hidden">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Logo Del Olympic"
                             class="h-14 w-auto object-contain">
                    </a>
                </div>

                {{-- Card login --}}
                <div class="bg-white rounded-3xl px-8 py-10 sm:px-10 login-card login-card-anim">

                    {{-- Header form --}}
                    <div class="mb-8">
                        <h2 class="text-2xl sm:text-3xl font-bold font-display text-slate-900">
                            Masuk ke Akun
                        </h2>
                        <p class="mt-1.5 text-slate-500 text-sm">
                            Gunakan email dan kata sandi yang telah terdaftar.
                        </p>
                    </div>

                    {{-- ===== ALERT: Pesan sukses (misal setelah logout) ===== --}}
                    @if (session('success'))
                        <div class="mb-5 flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-4 py-3.5 text-sm">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- ===== ALERT: Pesan error umum ===== --}}
                    @if (session('error'))
                        <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3.5 text-sm">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- ===== FORM MASUK ===== --}}
                    <form id="form-login"
                          method="POST"
                          action="{{ route('login.post') }}"
                          class="space-y-5"
                          novalidate>
                        @csrf

                        {{-- ======= FIELD EMAIL ======= --}}
                        <div>
                            <label for="email"
                                   class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Alamat Email
                            </label>
                            <div class="relative">
                                {{-- Icon email --}}
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
                            {{-- Pesan error email --}}
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
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password"
                                       class="block text-sm font-semibold text-slate-700">
                                    Kata Sandi
                                </label>
                                {{-- Link lupa kata sandi (placeholder untuk fitur mendatang) --}}
                                <span class="text-xs text-slate-400 cursor-default select-none"
                                      title="Fitur ini akan tersedia segera">
                                    Lupa kata sandi?
                                </span>
                            </div>
                            <div class="relative">
                                {{-- Icon kunci --}}
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
                                    autocomplete="current-password"
                                    required
                                    placeholder="••••••••"
                                    class="input-field w-full pl-10 pr-11 py-3 rounded-xl border
                                           {{ $errors->has('password') ? 'border-red-400 bg-red-50 text-red-900' : 'border-slate-200 bg-slate-50 text-slate-900' }}
                                           text-sm placeholder-slate-400
                                           focus:border-blue-500 focus:bg-white
                                           transition duration-150"
                                >
                                {{-- Tombol show/hide password --}}
                                <button
                                    type="button"
                                    id="toggle-password"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 transition"
                                    aria-label="Tampilkan / sembunyikan kata sandi">
                                    {{-- Icon mata (show) --}}
                                    <svg id="icon-eye" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{-- Icon mata dicoret (hide) --}}
                                    <svg id="icon-eye-off" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            {{-- Pesan error password --}}
                            @error('password')
                                <p class="mt-1.5 flex items-center gap-1.5 text-red-600 text-xs font-medium">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- ======= CHECKBOX INGAT SAYA ======= --}}
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                                <input
                                    id="remember"
                                    name="remember"
                                    type="checkbox"
                                    {{ old('remember') ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 
                                           focus:ring-blue-500 focus:ring-2 cursor-pointer
                                           accent-blue-600"
                                >
                                <span class="text-sm text-slate-600 group-hover:text-slate-800 transition">
                                    Ingat saya
                                </span>
                            </label>
                        </div>

                        {{-- ======= TOMBOL MASUK ======= --}}
                        <button
                            type="submit"
                            id="btn-submit"
                            class="w-full flex items-center justify-center gap-2 py-3.5 px-6 mt-2
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
                            <span id="btn-text">Masuk</span>
                        </button>

                    </form>

                    {{-- ======= DIVIDER ======= --}}
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white px-3 text-slate-400 font-medium">atau</span>
                        </div>
                    </div>

                    {{-- ======= LINK KE HALAMAN DAFTAR ======= --}}
                    <div class="text-center">
                        <p class="text-sm text-slate-600">
                            Belum memiliki akun?
                            {{-- Link ini akan dihubungkan ke halaman daftar yang dibuat teman kamu --}}
                            <a href="{{ route('register') }}"
                               class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>

                    {{-- ======= KOTAK ACUAN CONTOH LOGIN UNTUK UJI COBA WEBSITE ======= --}}
                    <div class="mt-6 p-4 bg-slate-50 border border-slate-200/90 rounded-2xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Akun Uji Coba Website
                            </span>
                            <span class="text-[10px] font-semibold text-blue-700 bg-blue-100/80 px-2 py-0.5 rounded-md">
                                Acuan Utama
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mb-3 leading-relaxed">
                            Gunakan satu akun acuan berikut untuk langsung mencoba login ke sistem:
                        </p>

                        <div class="bg-white p-3 rounded-xl border border-slate-200 text-xs space-y-1.5 font-mono mb-3 shadow-2xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 font-sans">Email:</span>
                                <span class="text-slate-900 font-semibold select-all">peserta@delolympic.id</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 font-sans">Kata Sandi:</span>
                                <span class="text-slate-900 font-semibold select-all">password123</span>
                            </div>
                            <div class="flex items-center justify-between pt-1 border-t border-slate-100 font-sans">
                                <span class="text-slate-400">Role / Status:</span>
                                <span class="text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded text-[11px]">Peserta (Aktif)</span>
                            </div>
                        </div>

                        <button type="button"
                                onclick="fillDemoCredentials('peserta@delolympic.id', 'password123')"
                                class="w-full py-2.5 px-3 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200/60 rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer shadow-2xs">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>Gunakan Akun Contoh Ini (Isi Otomatis)</span>
                        </button>
                    </div>

                    {{-- ======= INFO ROLE OTOMATIS ======= --}}
                    <div class="mt-4 p-3.5 bg-blue-50/70 border border-blue-100 rounded-2xl">
                        <p class="text-xs text-blue-700 font-semibold mb-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Satu Pintu Masuk
                        </p>
                        <p class="text-[11px] text-blue-600/80 leading-relaxed">
                            Sistem secara otomatis mengarahkan Anda ke Dashboard sesuai peran: <strong>Peserta</strong>, <strong>Penyelenggara</strong>, atau <strong>Admin</strong>.
                        </p>
                    </div>

                </div>

                {{-- Link kembali ke beranda --}}
                <div class="mt-6 text-center">
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
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
        // ========== Isi Otomatis Akun Demo ==========
        function fillDemoCredentials(email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            emailInput.value = email;
            passwordInput.value = password;
            emailInput.focus();
            const btn = document.getElementById('btn-submit');
            btn.classList.add('ring-4', 'ring-blue-300');
            setTimeout(() => btn.classList.remove('ring-4', 'ring-blue-300'), 600);
        }

        // ========== Toggle Show/Hide Password ==========
        function togglePassword() {
            const input    = document.getElementById('password');
            const iconShow = document.getElementById('icon-eye');
            const iconHide = document.getElementById('icon-eye-off');

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

        // ========== Loading State pada Submit ==========
        document.getElementById('form-login').addEventListener('submit', function (e) {
            const btn     = document.getElementById('btn-submit');
            const spinner = document.getElementById('btn-spinner');
            const text    = document.getElementById('btn-text');

            // Validasi sederhana sebelum submit
            const email    = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!email || !password) return; // biarkan HTML5 validation jalan

            // Tampilkan loading
            btn.classList.add('btn-loading');
            spinner.classList.remove('hidden');
            text.textContent = 'Memproses...';
        });

        // ========== Auto-dismiss alert setelah 5 detik ==========
        setTimeout(function () {
            const alerts = document.querySelectorAll('[data-auto-dismiss]');
            alerts.forEach(el => {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);

        // ========== Highlight input jika ada error ==========
        @if ($errors->any())
            // Fokus ke field email jika ada error
            document.getElementById('email').focus();
        @endif
    </script>
</body>
</html>
