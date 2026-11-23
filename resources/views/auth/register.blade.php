<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Del Olympic</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center font-['Inter']">
    <div class="text-center max-w-sm mx-auto px-6">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-14 w-auto mx-auto mb-6">
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold font-['Poppins'] text-slate-900 mb-2">Halaman Daftar</h1>
            <p class="text-slate-500 text-sm mb-6">
                Halaman pendaftaran sedang dalam pengembangan oleh anggota tim. Segera hadir!
            </p>
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-semibold hover:underline transition">
                ← Kembali ke halaman masuk
            </a>
        </div>
    </div>
</body>
</html>
