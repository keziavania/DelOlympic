<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Peserta') — Del Olympic</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
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
                            primary: '#1660eb',
                            dark: '#0b1c3d',
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
            color: #0f172a;
        }
        h1, h2, h3, h4, .font-display {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    @php
        $authUser = $user ?? auth()->user();
        $initials = collect(explode(' ', trim($authUser->name)))
            ->filter()
            ->take(2)
            ->map(fn (string $part): string => strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        $navItems = [
            [
                'label' => 'Beranda',
                'route' => 'peserta.dashboard',
                'active' => request()->routeIs('peserta.dashboard'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'label' => 'Jelajah Lomba',
                'route' => 'peserta.competitions.index',
                'active' => request()->routeIs('peserta.competitions.*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>',
            ],
            [
                'label' => 'Lomba Saya',
                'route' => 'peserta.registrations.index',
                'active' => request()->routeIs('peserta.registrations.*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
            ],
            [
                'label' => 'Jadwal & Pengumuman',
                'route' => 'peserta.schedule',
                'active' => request()->routeIs('peserta.schedule'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
            ],
            [
                'label' => 'Sertifikat & Hasil',
                'route' => 'peserta.certificates',
                'active' => request()->routeIs('peserta.certificates'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
            ],
            [
                'label' => 'Profil Saya',
                'route' => 'peserta.profile',
                'active' => request()->routeIs('peserta.profile*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
            ],
        ];
    @endphp

    <div class="min-h-screen flex">
        {{-- Mobile Sidebar Overlay --}}
        <div id="sidebar-backdrop"
             onclick="toggleMobileSidebar()"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden"></div>

        {{-- Left Sidebar --}}
        <aside id="peserta-sidebar"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200/90 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-out">
            <div>
                {{-- Brand Header --}}
                <div class="px-5 py-5 border-b border-slate-100 flex items-center justify-between">
                    <a href="{{ route('peserta.dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="Logo Del Olympic"
                             class="h-9 w-auto object-contain transition-transform group-hover:scale-105">
                        <div>
                            <div class="font-display font-bold text-slate-900 text-base leading-tight">Del Olympic</div>
                            <span class="inline-flex items-center mt-0.5 text-[11px] font-semibold bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">
                                Peserta
                            </span>
                        </div>
                    </a>
                    <button type="button"
                            onclick="toggleMobileSidebar()"
                            class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                            aria-label="Tutup menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Navigation Links --}}
                <nav class="p-3.5 space-y-1.5" aria-label="Menu Dashboard Peserta">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ $item['active'] ? 'bg-blue-50 text-blue-700 font-semibold shadow-2xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 flex-shrink-0 {{ $item['active'] ? 'text-blue-600' : 'text-slate-400' }}"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                {!! $item['icon'] !!}
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Footer / Logout --}}
            <div class="p-4 border-t border-slate-100 space-y-2">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-2.5 px-3.5 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Halaman Depan</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Shell --}}
        <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
            {{-- Top Navbar --}}
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/80">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        {{-- Mobile Drawer Trigger --}}
                        <button type="button"
                                onclick="toggleMobileSidebar()"
                                class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition"
                                aria-label="Buka menu navigasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        @hasSection('topbar_left')
                            @yield('topbar_left')
                        @else
                            <form action="{{ route('peserta.competitions.index') }}" method="GET" class="relative w-full max-w-md hidden sm:block">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text"
                                       name="q"
                                       value="{{ request('q') }}"
                                       placeholder="Cari lomba DMSC, POSI, Del Tech..."
                                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            </form>
                        @endif
                    </div>

                    <div class="flex items-center gap-3 flex-shrink-0">
                        <a href="{{ route('peserta.schedule') }}"
                           title="Jadwal & Pengumuman"
                           class="relative p-2 rounded-xl text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </a>

                        <a href="{{ route('peserta.profile') }}"
                           class="flex items-center gap-2.5 pl-1.5 pr-3 py-1 rounded-full border border-slate-200/80 hover:border-blue-300 hover:bg-blue-50/40 transition">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-sky-500 text-white font-display font-bold text-xs flex items-center justify-center shadow-xs">
                                {{ $initials ?: 'P' }}
                            </div>
                            <div class="hidden md:block text-left leading-tight">
                                <div class="text-xs font-semibold text-slate-900 truncate max-w-[140px]">{{ $authUser->name }}</div>
                                <div class="text-[11px] text-slate-500 truncate max-w-[140px]">{{ $authUser->school_name ?: 'Peserta Del Olympic' }}</div>
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-4 py-3.5 text-sm shadow-2xs">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3.5 text-sm shadow-2xs">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-6 flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-800 rounded-2xl px-4 py-3.5 text-sm shadow-2xs">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3.5 text-sm">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="space-y-1">
                            <p class="font-semibold text-red-900">Mohon periksa kembali isian berikut:</p>
                            <ul class="list-disc list-inside text-xs space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('peserta-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
