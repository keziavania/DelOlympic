<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin — Del Olympic</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen font-['Inter']">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
                <div>
                    <span class="text-sm font-semibold text-slate-900">Del Olympic</span>
                    <span class="ml-2 text-xs bg-red-100 text-red-700 font-semibold px-2 py-0.5 rounded-full">Admin</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1 hover:underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Lihat Beranda</span>
                </a>
                <span class="text-sm text-slate-600">{{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-sm text-red-600 hover:text-red-700 font-semibold hover:underline transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-2xl font-bold font-['Poppins'] text-slate-900">Dashboard Admin</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, <strong>{{ $user->name }}</strong>!</p>
        </div>

        <!-- Cards statistik placeholder -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500 font-medium">Total Penyelenggara</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">—</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500 font-medium">Total Event Aktif</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">—</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500 font-medium">Total Peserta</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">—</p>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 text-sm text-blue-800">
            ℹ️ Dashboard ini sedang dalam pengembangan. Fitur lengkap akan segera tersedia.
        </div>
    </main>
</body>
</html>
