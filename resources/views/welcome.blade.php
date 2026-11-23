<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Del Olympic - Platform Kompetisi Akademik & Olimpiade Terpercaya</title>

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
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            300: '#7cc7fb',
                            400: '#38a8f8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            primary: '#1660eb',
                            dark: '#0b1c3d'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        h1, h2, h3, h4, .font-display {
            font-family: 'Poppins', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-blue-600 selection:text-white">

    <!-- HERO SECTION WITH CAMPUS BACKGROUND -->
    <section class="relative min-h-[580px] sm:min-h-[640px] md:min-h-[700px] flex flex-col justify-between bg-cover bg-center bg-no-repeat overflow-hidden" 
             style="background-image: url('{{ asset('images/del-campus.jpg') }}');">
        
        <!-- Overlay halus agar foto tetap cerah dan teks sangat jelas -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/15 to-black/45 pointer-events-none"></div>

        <!-- FLOATING TOP NAVBAR BERBENTUK KAPSUL / PILL (SESUAI GAMBAR 3) -->
        <div class="relative z-30 w-full px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
            <header class="max-w-6xl mx-auto bg-white/95 backdrop-blur-md rounded-full shadow-lg shadow-black/10 border border-white/60 px-5 sm:px-8 py-2.5 sm:py-3 transition">
                <div class="flex items-center justify-between">
                    <!-- LOGO RESMI (GAMBAR KEDUA) -->
                    <a href="#" class="flex items-center group">
                        <img 
                            src="{{ asset('images/logo.png') }}" 
                            alt="Logo Del Olympic" 
                            class="h-9 sm:h-11 w-auto object-contain transition-transform group-hover:scale-105"
                        >
                    </a>

                    <!-- MENU NAVIGASI DENGAN ACTIVE PILL PADA 'BERANDA' (PERSIS GAMBAR 3) -->
                    <nav class="hidden md:flex items-center space-x-2 lg:space-x-4 text-sm">
                        <!-- Beranda with subtle pill background indicator -->
                        <a href="#" class="bg-slate-100 text-slate-900 font-semibold px-5 py-1.5 rounded-full transition shadow-2xs">
                            Beranda
                        </a>
                        <a href="#daftar-lomba" class="text-slate-600 hover:text-slate-900 font-medium px-4 py-1.5 rounded-full hover:bg-slate-50 transition">
                            Kompetisi
                        </a>
                        <a href="#pengumuman" class="text-slate-600 hover:text-slate-900 font-medium px-4 py-1.5 rounded-full hover:bg-slate-50 transition">
                            Pengumuman
                        </a>
                    </nav>

                    <!-- TOMBOL AKSI: DAFTAR & MASUK -->
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <!-- Tombol Daftar Akun -->
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs sm:text-sm px-4 sm:px-5 py-2 sm:py-2.5 rounded-full shadow-md shadow-blue-600/20 transition-all duration-150 space-x-1.5 group">
                            <!-- Icon User Plus / Register -->
                            <svg class="w-4 h-4 text-blue-100 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>Daftar</span>
                        </a>

                        <!-- Tombol Masuk / Login -->
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-[#0e1726] hover:bg-slate-900 text-white font-medium text-xs sm:text-sm px-4 sm:px-5 py-2 sm:py-2.5 rounded-full shadow-md shadow-slate-900/20 transition-all duration-150 space-x-1.5 group">
                            <!-- Icon Log In -->
                            <svg class="w-4 h-4 text-slate-200 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span>Masuk</span>
                        </a>
                    </div>
                </div>
            </header>
        </div>

        <!-- HERO CONTENT: JUDUL & TAGLINE "Show Your Skills. Own Your Moment." (TANPA WARNA LATAR, TULISAN SAJA TAPI SANGAT JELAS) -->
        <div class="relative z-20 max-w-4xl mx-auto px-4 sm:px-6 text-center my-auto py-16 sm:py-20">
            <!-- Judul Utama -->
            <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight font-display drop-shadow-[0_4px_16px_rgba(0,0,0,0.75)] leading-tight mb-4">
                Selamat Datang di<br>
                <span class="text-white">Del Olympic</span>
            </h1>

            <!-- Tagline Sesuai Permintaan (Tanpa latar belakang, tulisan tajam & kontras tinggi) -->
            <p class="text-base sm:text-xl md:text-2xl font-semibold text-white tracking-wide drop-shadow-[0_2px_10px_rgba(0,0,0,0.9)] max-w-2xl mx-auto">
                Show Your Skills. Own Your Moment.
            </p>
        </div>

        <!-- Bottom gradient fade into section below -->
        <div class="relative z-10 w-full h-10 bg-gradient-to-t from-slate-50 to-transparent"></div>
    </section>

    <!-- MAIN BODY SECTION -->
    <main class="flex-grow">
        
        <!-- HEADER HALAMAN: DAFTAR LOMBA, PENCARIAN & FILTER -->
        <section id="daftar-lomba" class="relative pt-12 pb-16 bg-slate-50 border-b border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Header Halaman -->
                <div class="text-center max-w-3xl mx-auto mb-10">
                    <div class="inline-flex items-center space-x-2 bg-blue-100/90 text-blue-700 border border-blue-200 px-3.5 py-1 rounded-full text-xs font-semibold mb-3">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                        <span>Portal Resmi Kompetisi & Olimpiade Akademik</span>
                    </div>

                    <!-- Judul Sesuai Ketentuan -->
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-display mb-3">
                        Daftar Lomba
                    </h2>

                    <!-- Deskripsi Sesuai Ketentuan -->
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        Temukan berbagai kompetisi akademik dan tunjukkan kemampuan terbaikmu melalui berbagai ajang olimpiade.
                    </p>
                </div>

                <!-- FILTER & PENCARIAN BOX INTERAKTIF -->
                <div id="filter-section" class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-6 shadow-sm shadow-slate-200/60 mb-10">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <!-- Kolom Pencarian Lomba -->
                        <div class="md:col-span-5 relative">
                            <label for="search-input" class="block text-xs font-semibold text-slate-700 mb-1.5">Pencarian Lomba</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <input 
                                    type="text" 
                                    id="search-input" 
                                    placeholder="Cari DMSC, POSI, Del Tech, atau topik..." 
                                    class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition"
                                    onkeyup="applyFilters()"
                                >
                                <button 
                                    id="clear-search-btn" 
                                    onclick="clearSearch()" 
                                    class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                                    title="Bersihkan pencarian"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Filter Kategori Kompetisi -->
                        <div class="md:col-span-3">
                            <label for="filter-category" class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori Kompetisi</label>
                            <div class="relative">
                                <select 
                                    id="filter-category" 
                                    class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none"
                                    onchange="applyFilters()"
                                >
                                    <option value="all">Semua Kategori</option>
                                    <option value="sains">Matematika & Sains</option>
                                    <option value="olimpiade">Olimpiade Nasional Terpadu</option>
                                    <option value="teknologi">Teknologi & IT</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4 fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Status Pendaftaran -->
                        <div class="md:col-span-3">
                            <label for="filter-status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status Pendaftaran</label>
                            <div class="relative">
                                <select 
                                    id="filter-status" 
                                    class="w-full py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition cursor-pointer appearance-none"
                                    onchange="applyFilters()"
                                >
                                    <option value="all">Semua Status</option>
                                    <option value="buka">Pendaftaran Dibuka</option>
                                    <option value="segera">Segera Dibuka</option>
                                    <option value="tutup">Ditutup</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <div class="md:col-span-1 pt-6 md:pt-5">
                            <button 
                                onclick="resetAllFilters()" 
                                title="Reset Filter"
                                class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl flex items-center justify-center transition"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Informasi Jumlah Lomba Yang Tersedia -->
                    <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs sm:text-sm text-slate-500">
                        <div class="flex items-center space-x-2">
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span id="competition-count-info" class="font-medium text-slate-700">
                                Menampilkan <strong class="text-blue-700" id="current-count">3</strong> dari 3 kompetisi yang tersedia
                            </span>
                        </div>
                        <div class="mt-2 sm:mt-0 text-slate-400 text-xs">
                            * Seluruh data perlombaan resmi terverifikasi panitia Del Olympic
                        </div>
                    </div>
                </div>

                <!-- EMPTY STATE NOTIFICATION -->
                <div id="no-results-state" class="hidden bg-white border border-slate-200 rounded-2xl p-12 text-center max-w-lg mx-auto shadow-sm my-8">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold font-display text-slate-800">Tidak ada kompetisi yang cocok</h3>
                    <p class="text-sm text-slate-500 mt-2 mb-5">Coba gunakan kata kunci lain atau ubah pengaturan filter kategori dan status pendaftaran.</p>
                    <button onclick="resetAllFilters()" class="text-sm font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition">
                        Reset Semua Filter
                    </button>
                </div>

                <!-- GRID 3 KARTU KOMPETISI: DMSC, POSI, DEL TECH (DENGAN GAMBAR TEMATIK & PESERTA PELAJAR) -->
                <div id="cards-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

                    <!-- KARTU 1: DMSC (Tema: Matematika & Sains) -->
                    <article 
                        class="competition-card bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group hover:-translate-y-1"
                        data-id="dmsc"
                        data-title="dmsc del mathematics and science competition matematika sains fisika sma smk pelajar"
                        data-category="sains"
                        data-status="buka"
                    >
                        <div>
                            <!-- Card Header dengan Gambar Tematik Matematika & Sains -->
                            <div class="relative h-48 sm:h-52 bg-slate-900 overflow-hidden">
                                <!-- Thematic Vector Graphic (Matematika, Rumus & Atom Sains - Tanpa Orang) -->
                                <img 
                                    src="{{ asset('images/dmsc-theme.svg') }}" 
                                    alt="DMSC - Matematika & Sains" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                >
                                <!-- Gradient Tint Overlay untuk kontras maksimal -->
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/85 via-blue-900/35 to-transparent"></div>

                                <!-- Konten Header di atas gambar tematik -->
                                <div class="absolute inset-0 p-5 flex flex-col justify-between z-10">
                                    <!-- Badges Atas -->
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/95 text-white shadow-xs backdrop-blur-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                                            Pendaftaran Dibuka
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                                            Matematika & Sains
                                        </span>
                                    </div>

                                    <!-- Identitas Kompetisi -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-xl bg-white/95 backdrop-blur-xs text-blue-700 flex items-center justify-center font-bold text-xl shadow-md font-display">
                                            &Sigma;
                                        </div>
                                        <div class="text-white">
                                            <div class="text-[11px] uppercase font-semibold tracking-wider text-blue-200">Olimpiade Tahunan</div>
                                            <div class="text-2xl font-extrabold font-display leading-tight drop-shadow-sm">DMSC 2026</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold font-display text-slate-900 group-hover:text-blue-600 transition">
                                    Del Mathematics and Science Competition (DMSC)
                                </h3>
                                <p class="text-xs font-medium text-slate-400 mt-0.5 mb-3">
                                    Diselenggarakan oleh Institut Teknologi Del
                                </p>
                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-5">
                                    Kompetisi bergengsi tahunan yang menguji ketajaman logika matematika dan pemahaman sains mendalam bagi siswa/i tingkat menengah atas di seluruh nusantara.
                                </p>

                                <!-- Metadata List: Label Peserta (Khusus Pelajar) -->
                                <div class="space-y-2.5 pt-2 border-t border-slate-100 text-xs text-slate-600">
                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-del-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Peserta
                                        </span>
                                        <span class="font-semibold text-slate-800">SMA / SMK / MA Sederajat</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-del-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Batas Pendaftaran
                                        </span>
                                        <span class="font-semibold text-slate-800">15 Desember 2026</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-del-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Biaya Registrasi
                                        </span>
                                        <span class="font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">Rp 75.000 / Peserta</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-del-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                            Total Apresiasi
                                        </span>
                                        <span class="font-semibold text-emerald-600">Rp 25.000.000 + Beasiswa</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action Buttons -->
                        <div class="p-6 pt-0 bg-white">
                            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100">
                                <button 
                                    onclick="openDetailModal('dmsc')" 
                                    class="w-full text-center py-2.5 px-3 rounded-xl border border-slate-200 hover:border-blue-400 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-semibold transition"
                                >
                                    Detail Lomba
                                </button>
                                <button 
                                    onclick="openRegisterModal('DMSC 2026 - Del Mathematics and Science Competition')" 
                                    class="w-full text-center py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs hover:shadow-md transition"
                                >
                                    Daftar Sekarang
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- KARTU 2: POSI (Tema: Olimpiade Sains Nasional - Pelajar SMP & SMA) -->
                    <article 
                        class="competition-card bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group hover:-translate-y-1"
                        data-id="posi"
                        data-title="posi pusat olimpiade indonesia sains nasional smp sma pelajar"
                        data-category="olimpiade"
                        data-status="buka"
                    >
                        <div>
                            <!-- Card Header dengan Gambar Tematik Olimpiade Sains & Medali Emas -->
                            <div class="relative h-48 sm:h-52 bg-slate-900 overflow-hidden">
                                <!-- Thematic Vector Graphic (Medali Emas Olimpiade, Daun Zaitun, Tabung Reaksi - Tanpa Orang / Tanpa Bunga) -->
                                <img 
                                    src="{{ asset('images/posi-theme.svg') }}" 
                                    alt="POSI - Olimpiade Sains Nasional" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                >
                                <!-- Gradient Tint Overlay untuk kontras maksimal -->
                                <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/85 via-indigo-900/35 to-transparent"></div>

                                <!-- Konten Header di atas gambar tematik -->
                                <div class="absolute inset-0 p-5 flex flex-col justify-between z-10">
                                    <!-- Badges Atas -->
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/95 text-white shadow-xs backdrop-blur-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                                            Pendaftaran Dibuka
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                                            Olimpiade Nasional
                                        </span>
                                    </div>

                                    <!-- Identitas Kompetisi -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-xl bg-white/95 backdrop-blur-xs text-sky-700 flex items-center justify-center font-bold text-lg shadow-md font-display">
                                            POSI
                                        </div>
                                        <div class="text-white">
                                            <div class="text-[11px] uppercase font-semibold tracking-wider text-sky-200">Kolaborasi Resmi</div>
                                            <div class="text-2xl font-extrabold font-display leading-tight drop-shadow-sm">POSI x Del</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold font-display text-slate-900 group-hover:text-blue-600 transition">
                                    Pusat Olimpiade Indonesia (POSI)
                                </h3>
                                <p class="text-xs font-medium text-slate-400 mt-0.5 mb-3">
                                    Kemitraan Strategis POSI bersama Del Olympic
                                </p>
                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-5">
                                    Ajang seleksi dan asah kompetensi sains berskala nasional yang dirancang sesuai standar silabus olimpiade nasional khusus pelajar SMP dan SMA.
                                </p>

                                <!-- Metadata List: Label Peserta (Khusus Pelajar SMP & SMA) -->
                                <div class="space-y-2.5 pt-2 border-t border-slate-100 text-xs text-slate-600">
                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Peserta
                                        </span>
                                        <span class="font-semibold text-slate-800">SMP & SMA Sederajat</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Batas Pendaftaran
                                        </span>
                                        <span class="font-semibold text-slate-800">28 Desember 2026</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Biaya Registrasi
                                        </span>
                                        <span class="font-bold text-sky-700 bg-sky-50 px-2 py-0.5 rounded">Rp 50.000 / Peserta</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                            Total Apresiasi
                                        </span>
                                        <span class="font-semibold text-emerald-600">Medali Fisik + Piagam Resmi</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action Buttons -->
                        <div class="p-6 pt-0 bg-white">
                            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100">
                                <button 
                                    onclick="openDetailModal('posi')" 
                                    class="w-full text-center py-2.5 px-3 rounded-xl border border-slate-200 hover:border-sky-400 hover:bg-sky-50 text-slate-700 hover:text-sky-700 text-xs font-semibold transition"
                                >
                                    Detail Lomba
                                </button>
                                <button 
                                    onclick="openRegisterModal('POSI - Pusat Olimpiade Indonesia')" 
                                    class="w-full text-center py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs hover:shadow-md transition"
                                >
                                    Daftar Sekarang
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- KARTU 3: DEL TECH (Tema: Teknologi, Pemrograman & IT) -->
                    <article 
                        class="competition-card bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group hover:-translate-y-1"
                        data-id="deltech"
                        data-title="del tech del technology competition informatika pemrograman coding ui ux web teknologi inovasi pelajar"
                        data-category="teknologi"
                        data-status="buka"
                    >
                        <div>
                            <!-- Card Header dengan Gambar Tematik Teknologi & Software Coding -->
                            <div class="relative h-48 sm:h-52 bg-slate-900 overflow-hidden">
                                <!-- Thematic Vector Graphic (Code Editor Terminal, Circuit Traces & Binary - Tanpa Orang) -->
                                <img 
                                    src="{{ asset('images/deltech-theme.svg') }}" 
                                    alt="Del Tech - Teknologi & IT" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                >
                                <!-- Gradient Tint Overlay untuk kontras maksimal -->
                                <div class="absolute inset-0 bg-gradient-to-t from-teal-950/85 via-teal-900/35 to-transparent"></div>

                                <!-- Konten Header di atas gambar tematik -->
                                <div class="absolute inset-0 p-5 flex flex-col justify-between z-10">
                                    <!-- Badges Atas -->
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/95 text-white shadow-xs backdrop-blur-xs">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                                            Pendaftaran Dibuka
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                                            Teknologi & IT
                                        </span>
                                    </div>

                                    <!-- Identitas Kompetisi -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-xl bg-white/95 backdrop-blur-xs text-teal-800 flex items-center justify-center font-bold text-lg shadow-md font-display">
                                            &lt;/&gt;
                                        </div>
                                        <div class="text-white">
                                            <div class="text-[11px] uppercase font-semibold tracking-wider text-teal-200">Inovasi Digital</div>
                                            <div class="text-2xl font-extrabold font-display leading-tight drop-shadow-sm">Del Tech 2026</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold font-display text-slate-900 group-hover:text-blue-600 transition">
                                    Del Technology Competition (Del Tech)
                                </h3>
                                <p class="text-xs font-medium text-slate-400 mt-0.5 mb-3">
                                    Fakultas Informatika & Teknik Elektro IT Del
                                </p>
                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-5">
                                    Kompetisi teknologi masa depan mencakup Competitive Programming, Web & UI/UX Design, serta Inovasi Solusi AI untuk menyelesaikan isu nyata.
                                </p>

                                <!-- Metadata List: Label Peserta (SMA/SMK & Mahasiswa) -->
                                <div class="space-y-2.5 pt-2 border-t border-slate-100 text-xs text-slate-600">
                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Peserta
                                        </span>
                                        <span class="font-semibold text-slate-800">SMA/SMK & Mahasiswa (Tim)</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Batas Pendaftaran
                                        </span>
                                        <span class="font-semibold text-slate-800">20 Desember 2026</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Biaya Registrasi
                                        </span>
                                        <span class="font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded">Rp 100.000 / Tim</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="flex items-center text-slate-500">
                                            <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                            Total Apresiasi
                                        </span>
                                        <span class="font-semibold text-emerald-600">Rp 35.000.000 + Trophy</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action Buttons -->
                        <div class="p-6 pt-0 bg-white">
                            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100">
                                <button 
                                    onclick="openDetailModal('deltech')" 
                                    class="w-full text-center py-2.5 px-3 rounded-xl border border-slate-200 hover:border-teal-400 hover:bg-teal-50 text-slate-700 hover:text-teal-700 text-xs font-semibold transition"
                                >
                                    Detail Lomba
                                </button>
                                <button 
                                    onclick="openRegisterModal('Del Tech 2026 - Del Technology Competition')" 
                                    class="w-full text-center py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs hover:shadow-md transition"
                                >
                                    Daftar Sekarang
                                </button>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>

        <!-- SECTION PENGUMUMAN & TIMELINE -->
        <section id="pengumuman" class="py-16 bg-white border-b border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">Informasi Resmi</span>
                    <h2 class="text-3xl font-extrabold font-display text-slate-900 mt-2">Pengumuman & Timeline Penting</h2>
                    <p class="text-sm text-slate-500 mt-2">Perhatikan jadwal tahapan kompetisi agar tidak terlewat tanggal penting.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 hover:border-blue-300 transition">
                        <div class="text-xs font-semibold text-blue-700 bg-blue-100/60 inline-block px-2.5 py-1 rounded-md mb-3">10 Okt - 28 Des 2026</div>
                        <h4 class="font-bold text-slate-900 mb-2">Masa Pendaftaran & Verifikasi Berkas</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Pengisian biodata peserta, pengunggahan surat rekomendasi sekolah, dan konfirmasi pembayaran administrasi.</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 hover:border-blue-300 transition">
                        <div class="text-xs font-semibold text-emerald-700 bg-emerald-100/60 inline-block px-2.5 py-1 rounded-md mb-3">20 Des 2026 & 10 Jan 2027</div>
                        <h4 class="font-bold text-slate-900 mb-2">Pelaksanaan Babak Penyisihan & Final</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Ujian kompetisi berbasis CBT (Computer Based Test) secara daring dan hybrid terpusat di Kampus IT Del.</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200/80 hover:border-blue-300 transition">
                        <div class="text-xs font-semibold text-amber-700 bg-amber-100/60 inline-block px-2.5 py-1 rounded-md mb-3">15 Januari 2027</div>
                        <h4 class="font-bold text-slate-900 mb-2">Awarding & Pengumuman Juara</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Penganugerahan piala, medali, penyerahan hadiah uang pembinaan, serta publikasi hasil resmi pemenang olimpiade.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER RESMI DEL OLYMPIC -->
    <footer class="bg-slate-900 text-slate-400 text-sm pt-12 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 pb-8 border-b border-slate-800">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-white p-1.5 rounded-xl inline-block shadow-sm">
                            <img src="{{ asset('images/logo.png') }}" alt="Del Olympic" class="h-8 w-auto">
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        Platform resmi informasi dan pendaftaran kompetisi olimpiade akademik Institut Teknologi Del. Mendorong generasi berkarakter MarTuhan, Marroha, Marbisuk berprestasi di tingkat nasional dan global.
                    </p>
                    <p class="text-xs text-slate-500 mt-4">
                        Jl. Sisingamangaraja, Sitoluama, Laguboti, Kabupaten Toba, Sumatera Utara 22381
                    </p>
                </div>

                <div>
                    <h5 class="text-white text-xs font-bold uppercase tracking-wider mb-3">Daftar Kompetisi</h5>
                    <ul class="space-y-2 text-xs">
                        <li><a href="javascript:void(0)" onclick="quickSelectCategory('sains')" class="hover:text-blue-400 transition">DMSC (Matematika & Sains)</a></li>
                        <li><a href="javascript:void(0)" onclick="quickSelectCategory('olimpiade')" class="hover:text-blue-400 transition">POSI x Del Collaboration</a></li>
                        <li><a href="javascript:void(0)" onclick="quickSelectCategory('teknologi')" class="hover:text-blue-400 transition">Del Tech (Teknologi & IT)</a></li>
                        <li><a href="#pengumuman" class="hover:text-blue-400 transition">Pengumuman & Timeline</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-white text-xs font-bold uppercase tracking-wider mb-3">Kontak & Bantuan</h5>
                    <ul class="space-y-2 text-xs">
                        <li class="flex items-center">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                            <span>Email: olympic@del.ac.id</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                            <span>WhatsApp: +62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                            <span>Instagram: @delolympic.official</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; 2026 Del Olympic - Institut Teknologi Del. Seluruh hak cipta dilindungi.</p>
                <div class="flex space-x-4 mt-3 sm:mt-0">
                    <a href="#" class="hover:text-slate-400">Kebijakan Privasi</a>
                    <span>&bull;</span>
                    <a href="#" class="hover:text-slate-400">Syarat & Ketentuan</a>
                    <span>&bull;</span>
                    <a href="#" class="hover:text-slate-400">Buku Panduan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- MODAL DETAIL LOMBA INTERAKTIF -->
    <div id="detail-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in-95 duration-200">
            <button onclick="closeDetailModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-full p-1.5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div id="modal-content">
                <!-- Injected via JavaScript -->
            </div>
        </div>
    </div>

    <!-- MODAL PENDAFTARAN CEPAT -->
    <div id="register-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-100 relative">
            <button onclick="closeRegisterModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-full p-1.5 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>

            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>

            <h3 class="text-xl font-bold font-display text-slate-900">Formulir Pendaftaran</h3>
            <p id="register-target-competition" class="text-xs font-semibold text-blue-700 mt-1 mb-4">
                Pilihan Kompetisi
            </p>

            <div class="space-y-3.5 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap Peserta / Ketua Tim</label>
                    <input type="text" placeholder="Masukkan nama sesuai kartu identitas" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Asal Sekolah / Universitas</label>
                    <input type="text" placeholder="Contoh: SMA Negeri 1 Laguboti" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                    <input type="tel" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <button onclick="closeRegisterModal()" class="w-1/2 py-2.5 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button onclick="submitDummyRegistration()" class="w-1/2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition">
                    Lanjut Pendaftaran
                </button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC UNTUK SEARCH, FILTER & MODAL -->
    <script>
        const competitionData = {
            dmsc: {
                title: "DMSC 2026 - Del Mathematics and Science Competition",
                category: "Matematika & Sains Terapan",
                organizer: "Institut Teknologi Del (IT Del)",
                target: "Siswa/i SMA / SMK / MA Sederajat Seluruh Indonesia",
                registrationPeriod: "10 Oktober 2026 s.d. 15 Desember 2026",
                eventDate: "20 Desember 2026",
                fee: "Rp 75.000 / Peserta",
                prizes: [
                    "Juara 1: Trophy + Piagam + Uang Pembinaan Rp 10.000.000 + Beasiswa Kuliah IT Del",
                    "Juara 2: Trophy + Piagam + Uang Pembinaan Rp 7.500.000",
                    "Juara 3: Trophy + Piagam + Uang Pembinaan Rp 5.000.000",
                    "Seluruh Peserta: E-Sertifikat Nasional ber-barcode verifikasi resmi"
                ],
                syllabus: "Matematika Diskrit, Kalkulus Dasar, Logika Geometri, Fisika Mekanika, Termodinamika & Gelombang Sains.",
                description: "DMSC merupakan agenda tahunan prestisius yang diadakan oleh civitas akademika IT Del untuk memupuk daya nalar kritis dan analitis calon generasi saintis masa depan."
            },
            posi: {
                title: "POSI x Del - Pusat Olimpiade Indonesia",
                category: "Olimpiade Sains Nasional Terpadu",
                organizer: "Pusat Olimpiade Indonesia (POSI) bekerja sama dengan Del Olympic",
                target: "Pelajar SMP & SMA Sederajat Seluruh Indonesia",
                registrationPeriod: "1 November 2026 s.d. 28 Desember 2026",
                eventDate: "10 Januari 2027",
                fee: "Rp 50.000 / Peserta",
                prizes: [
                    "Medali Fisik (Emas, Perak, Perunggu) dikirim langsung ke alamat sekolah/peserta",
                    "Piagam Penghargaan resmi tingkat nasional berlisensi POSI",
                    "Akses pembahasan soal eksklusif dan pembinaan bimbingan juara",
                    "E-Sertifikat Nasional berlisensi resmi"
                ],
                syllabus: "Bidang Matematika Terpadu, IPA / Biologi Terpadu, Fisika, Astronomi & Kebumian standar OSN Pusat Prestasi Nasional.",
                description: "POSI adalah wadah kompetisi sains terpercaya di Indonesia dengan rekam jejak puluhan ribu peserta pelajar tiap tahun yang siap mencetak jawara sains tingkat nasional."
            },
            deltech: {
                title: "Del Tech 2026 - Del Technology Competition",
                category: "Teknologi Informasi & Rekayasa Komputer",
                organizer: "Fakultas Informatika & Teknik Elektro Institut Teknologi Del",
                target: "Siswa SMA/SMK dan Mahasiswa Aktif (Tim 1 - 3 Orang)",
                registrationPeriod: "15 Oktober 2026 s.d. 20 Desember 2026",
                eventDate: "5 Januari 2027",
                fee: "Rp 100.000 / Tim",
                prizes: [
                    "Juara 1: Piala Bergilir Rektor + Uang Pembinaan Rp 15.000.000 + Golden Ticket Magang",
                    "Juara 2: Trophy + Uang Pembinaan Rp 10.000.000",
                    "Juara 3: Trophy + Uang Pembinaan Rp 7.000.000",
                    "Best Innovation Award: Rp 3.000.000"
                ],
                syllabus: "Pilihan cabang: 1. Algoritma & Competitive Programming (C++, Java, Python), 2. Web UI/UX Design Challenge, 3. Artificial Intelligence & IoT Solution Prototype.",
                description: "Del Tech menantang kreativitas generasi muda dalam rekayasa perangkat lunak dan solusi teknologi berdampak tinggi untuk menjawab problem nyata di era Society 5.0."
            }
        };

        // Real-time filter and search function
        function applyFilters() {
            const searchQuery = document.getElementById('search-input').value.toLowerCase().trim();
            const selectedCategory = document.getElementById('filter-category').value;
            const selectedStatus = document.getElementById('filter-status').value;
            const clearBtn = document.getElementById('clear-search-btn');

            if (searchQuery.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            const cards = document.querySelectorAll('.competition-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const titleText = card.getAttribute('data-title') || '';
                const category = card.getAttribute('data-category') || '';
                const status = card.getAttribute('data-status') || '';

                const matchesSearch = searchQuery === '' || titleText.includes(searchQuery);
                const matchesCategory = selectedCategory === 'all' || category === selectedCategory;
                const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

                if (matchesSearch && matchesCategory && matchesStatus) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Update visible counter
            const currentCountEl = document.getElementById('current-count');
            if (currentCountEl) {
                currentCountEl.textContent = visibleCount;
            }

            // Show or hide empty state
            const noResultsState = document.getElementById('no-results-state');
            const cardsContainer = document.getElementById('cards-container');

            if (visibleCount === 0) {
                noResultsState.classList.remove('hidden');
                cardsContainer.classList.add('hidden');
            } else {
                noResultsState.classList.add('hidden');
                cardsContainer.classList.remove('hidden');
            }
        }

        function clearSearch() {
            document.getElementById('search-input').value = '';
            applyFilters();
            document.getElementById('search-input').focus();
        }

        function resetAllFilters() {
            document.getElementById('search-input').value = '';
            document.getElementById('filter-category').value = 'all';
            document.getElementById('filter-status').value = 'all';
            applyFilters();
        }

        function quickSelectCategory(cat) {
            document.getElementById('filter-category').value = cat;
            applyFilters();
            const filterSec = document.getElementById('daftar-lomba');
            if (filterSec) {
                filterSec.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Modal Detail Logic
        function openDetailModal(compKey) {
            const data = competitionData[compKey];
            if (!data) return;

            const modalContent = document.getElementById('modal-content');
            modalContent.innerHTML = `
                <div class="inline-block bg-blue-100 text-blue-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full mb-2">
                    ${data.category}
                </div>
                <h3 class="text-xl font-bold font-display text-slate-900 leading-snug mb-1">
                    ${data.title}
                </h3>
                <p class="text-xs text-slate-500 mb-4">${data.organizer}</p>
                
                <p class="text-xs text-slate-600 leading-relaxed mb-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
                    ${data.description}
                </p>

                <div class="space-y-2 text-xs border-y border-slate-100 py-3 mb-4">
                    <div class="flex justify-between"><span class="text-slate-500">Peserta:</span> <strong class="text-slate-800">${data.target}</strong></div>
                    <div class="flex justify-between"><span class="text-slate-500">Masa Pendaftaran:</span> <strong class="text-slate-800">${data.registrationPeriod}</strong></div>
                    <div class="flex justify-between"><span class="text-slate-500">Tanggal Pelaksanaan:</span> <strong class="text-blue-700">${data.eventDate}</strong></div>
                    <div class="flex justify-between"><span class="text-slate-500">Biaya Pendaftaran:</span> <strong class="text-emerald-600">${data.fee}</strong></div>
                </div>

                <div class="mb-4">
                    <h5 class="text-xs font-bold text-slate-800 mb-1.5">Penghargaan & Hadiah:</h5>
                    <ul class="text-xs text-slate-600 list-disc list-inside space-y-1">
                        ${data.prizes.map(p => `<li>${p}</li>`).join('')}
                    </ul>
                </div>

                <div class="mb-5">
                    <h5 class="text-xs font-bold text-slate-800 mb-1">Silabus Materi:</h5>
                    <p class="text-xs text-slate-500">${data.syllabus}</p>
                </div>

                <div class="flex space-x-3 pt-2">
                    <button onclick="closeDetailModal()" class="w-1/2 py-2.5 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Tutup
                    </button>
                    <button onclick="closeDetailModal(); openRegisterModal('${data.title}')" class="w-1/2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition">
                        Daftar Lomba Ini
                    </button>
                </div>
            `;

            document.getElementById('detail-modal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        // Modal Register Logic
        function openRegisterModal(competitionName) {
            document.getElementById('register-target-competition').textContent = "Pilihan: " + competitionName;
            document.getElementById('register-modal').classList.remove('hidden');
        }

        function closeRegisterModal() {
            document.getElementById('register-modal').classList.add('hidden');
        }

        function submitDummyRegistration() {
            alert("Terima kasih! Data pendaftaran awal berhasil dicatat. Petunjuk pembayaran dan kelengkapan dokumen telah dikirimkan ke nomor kontak yang Anda isi.");
            closeRegisterModal();
        }

        function openLoginNotice(e) {
            e.preventDefault();
            alert("Fitur Masuk / Login akan segera dibuka pada tahap rilis pendaftaran gelombang pertama!");
        }

        // Close modal when clicking outside modal box
        window.onclick = function(event) {
            const detailModal = document.getElementById('detail-modal');
            const registerModal = document.getElementById('register-modal');
            if (event.target === detailModal) {
                closeDetailModal();
            }
            if (event.target === registerModal) {
                closeRegisterModal();
            }
        };
    </script>
</body>
</html>
