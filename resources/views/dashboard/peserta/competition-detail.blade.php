@extends('layouts.peserta')

@section('title', 'Detail Lomba — '.$competition->short_title)

@section('topbar_left')
    <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 truncate" aria-label="Breadcrumb">
        <a href="{{ route('peserta.competitions.index') }}" class="hover:text-blue-600 font-medium transition">Jelajah Lomba</a>
        <span>/</span>
        <span class="font-semibold text-slate-900 truncate">{{ $competition->short_title }}</span>
    </nav>
@endsection

@section('content')
    @php
        $bannerGradient = match ($competition->accent_color) {
            'sky' => 'from-[#0f172a] via-sky-800 to-blue-600',
            'teal' => 'from-[#0b1c3d] via-teal-800 to-emerald-600',
            default => 'from-[#0b1c3d] via-[#1640a8] to-[#1660eb]',
        };
    @endphp

    {{-- Competition Full Header Banner --}}
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r {{ $bannerGradient }} text-white p-6 sm:p-8 shadow-md mb-6">
        @if ($competition->theme_image)
            <img src="{{ asset($competition->theme_image) }}"
                 alt=""
                 class="absolute right-0 top-0 h-full w-1/2 object-cover opacity-20 mix-blend-screen pointer-events-none hidden md:block">
        @endif

        <div class="relative z-10 max-w-3xl">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    {{ $competition->statusLabel() }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/15 border border-white/25 backdrop-blur-xs">
                    {{ $competition->category_label }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/15 border border-white/25 backdrop-blur-xs">
                    {{ $competition->isTeamCompetition() ? 'Tim ('.$competition->min_team_members.'–'.$competition->max_team_members.' Orang)' : 'Individu' }}
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold font-display tracking-tight leading-snug">
                {{ $competition->short_title }} — {{ $competition->title }}
            </h1>

            <p class="text-xs sm:text-sm text-blue-100 mt-2 flex flex-wrap items-center gap-x-2 gap-y-1">
                <span>Diselenggarakan oleh <strong>{{ $competition->organizer }}</strong></span>
                @if ($user->education_level)
                    <span>•</span>
                    @if ($isEligibleLevel)
                        <span class="text-emerald-300 font-semibold">✓ Cocok untuk Jenjang Anda ({{ $user->education_level }})</span>
                    @else
                        <span class="text-amber-200 font-medium">Target: {{ $competition->education_label }}</span>
                    @endif
                @endif
            </p>
        </div>
    </section>

    {{-- Existing Registration Banner --}}
    @if ($existingRegistration)
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-sm font-bold text-emerald-900">Anda sudah terdaftar di kompetisi ini</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $existingRegistration->statusBadgeClasses() }}">
                            {{ $existingRegistration->statusLabel() }}
                        </span>
                    </div>
                    <p class="text-xs text-emerald-800 mt-1">
                        Nomor Registrasi: <strong class="font-mono">{{ $existingRegistration->registration_number }}</strong>
                        @if ($existingRegistration->branch)
                            • Bidang: <strong>{{ $existingRegistration->branch }}</strong>
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                @if ($existingRegistration->isVerified())
                    <a href="{{ route('peserta.registrations.card', $existingRegistration) }}"
                       class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition">
                        Unduh Kartu Peserta
                    </a>
                @else
                    <a href="{{ route('peserta.registrations.index') }}#upload-{{ $existingRegistration->id }}"
                       class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition">
                        Kelola / Unggah Berkas
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Two-Column Detail Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- Left Column (8 cols): Interactive Tabs + Detailed Sections --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Tab Bar --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 px-3 pt-2 flex items-center gap-1 overflow-x-auto">
                <button type="button" onclick="switchDetailTab('ringkasan')" id="tab-btn-ringkasan"
                        class="detail-tab-btn px-4 py-2.5 text-xs sm:text-sm font-semibold border-b-2 border-blue-600 text-blue-600 whitespace-nowrap cursor-pointer">
                    Ringkasan & Silabus
                </button>
                <button type="button" onclick="switchDetailTab('timeline')" id="tab-btn-timeline"
                        class="detail-tab-btn px-4 py-2.5 text-xs sm:text-sm font-medium border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap cursor-pointer">
                    Timeline Tahapan
                </button>
                <button type="button" onclick="switchDetailTab('syarat')" id="tab-btn-syarat"
                        class="detail-tab-btn px-4 py-2.5 text-xs sm:text-sm font-medium border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap cursor-pointer">
                    Syarat & Berkas
                </button>
                <button type="button" onclick="switchDetailTab('hadiah')" id="tab-btn-hadiah"
                        class="detail-tab-btn px-4 py-2.5 text-xs sm:text-sm font-medium border-b-2 border-transparent text-slate-500 hover:text-slate-800 whitespace-nowrap cursor-pointer">
                    Hadiah & Penghargaan
                </button>
            </div>

            {{-- TAB 1: RINGKASAN & SILABUS --}}
            <div id="tab-panel-ringkasan" class="detail-tab-panel space-y-6">
                {{-- Deskripsi Lengkap --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                    <h2 class="text-base font-bold font-display text-slate-900 mb-2">Tentang Kompetisi</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $competition->description }}</p>

                    @if (! empty($competition->branches))
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2.5">Cabang / Bidang Lomba Tersedia</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($competition->branches as $branch)
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 text-xs font-semibold">
                                        {{ $branch }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Timeline Ringkas 4 Langkah (sesuai mockup) --}}
                @if (! empty($competition->timeline))
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-base font-bold font-display text-slate-900">Timeline Tahapan Lomba</h2>
                            <button type="button" onclick="switchDetailTab('timeline')" class="text-xs font-semibold text-blue-600 hover:underline cursor-pointer">
                                Rincian Tahapan →
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
                            @foreach ($competition->timeline as $index => $stage)
                                <div class="relative flex sm:flex-col items-start sm:items-center sm:text-center gap-3 sm:gap-2">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 {{ $index === 0 ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                        {{ $stage['step'] ?? ($index + 1) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900 leading-snug">{{ $stage['title'] }}</p>
                                        <p class="text-[11px] font-medium text-blue-600 mt-0.5">{{ $stage['date_label'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Silabus & Syarat Side-by-Side (persis mockup) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Silabus & Buku Panduan --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 flex flex-col justify-between">
                        <div>
                            <h2 class="text-base font-bold font-display text-slate-900 mb-3">Silabus & Kisi-Kisi Materi</h2>
                            <div class="flex flex-wrap gap-2 mb-5">
                                @foreach ($competition->syllabus ?? [] as $topic)
                                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-medium">
                                        {{ $topic }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-lg bg-red-100 text-red-600 flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                                    PDF
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-800 truncate">Buku Panduan Resmi {{ $competition->short_title }}.pdf</p>
                                    <p class="text-[11px] text-slate-500">Tata tertib, silabus & contoh soal</p>
                                </div>
                            </div>
                            <button type="button"
                                    onclick="document.getElementById('guidebook-modal').classList.remove('hidden')"
                                    class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-700 text-xs font-semibold text-slate-700 transition flex-shrink-0 cursor-pointer">
                                Baca Panduan
                            </button>
                        </div>
                    </div>

                    {{-- Syarat & Berkas Wajib --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5">
                        <h2 class="text-base font-bold font-display text-slate-900 mb-3">Syarat & Berkas Wajib</h2>
                        <ul class="space-y-3">
                            @foreach ($competition->requirements ?? [] as $req)
                                <li class="flex items-start gap-2.5 text-xs text-slate-600 leading-relaxed">
                                    <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    <span>{{ $req }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- TAB 2: TIMELINE TAHAPAN LENGKAP --}}
            <div id="tab-panel-timeline" class="detail-tab-panel hidden">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                    <h2 class="text-base font-bold font-display text-slate-900 mb-4">Rincian Jadwal & Tahapan {{ $competition->short_title }}</h2>
                    <div class="space-y-4">
                        @foreach ($competition->timeline ?? [] as $stage)
                            <div class="flex gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-display font-bold text-sm flex items-center justify-center flex-shrink-0">
                                    {{ $stage['step'] }}
                                </div>
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $stage['title'] }}</h3>
                                        <span class="text-xs font-semibold text-blue-700 bg-blue-100/80 px-2.5 py-0.5 rounded-full">{{ $stage['date_label'] }}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $stage['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- TAB 3: SYARAT & BERKAS --}}
            <div id="tab-panel-syarat" class="detail-tab-panel hidden">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6 space-y-5">
                    <div>
                        <h2 class="text-base font-bold font-display text-slate-900 mb-2">Persyaratan Peserta & Kelengkapan Berkas</h2>
                        <p class="text-xs text-slate-500">Siapkan dokumen berikut dalam format JPG, PNG, atau PDF (maksimal 4 MB per berkas) untuk diunggah setelah mendaftar.</p>
                    </div>
                    <ul class="space-y-3">
                        @foreach ($competition->requirements ?? [] as $req)
                            <li class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-100 text-xs sm:text-sm text-slate-700">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">✓</span>
                                <span>{{ $req }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 text-xs text-blue-800">
                        <strong>Info Rekening Pembayaran Resmi:</strong> Bank BNI a.n. Panitia Del Olympic IT Del — No. Rek <strong>0812-3456-7890</strong>. Cantumkan nama peserta/tim pada berita transfer.
                    </div>
                </div>
            </div>

            {{-- TAB 4: HADIAH & PENGHARGAAN --}}
            <div id="tab-panel-hadiah" class="detail-tab-panel hidden">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                        <h2 class="text-base font-bold font-display text-slate-900">Hadiah, Medali & Penghargaan</h2>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                            {{ $competition->total_prize_summary }}
                        </span>
                    </div>
                    <div class="space-y-3">
                        @foreach ($competition->prizes ?? [] as $prize)
                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-amber-50/50 border border-amber-100 text-xs sm:text-sm text-slate-800">
                                <span class="text-amber-500 text-base leading-none mt-0.5">★</span>
                                <span>{{ $prize }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Form Pendaftaran Lomba Langsung (di dalam halaman detail) --}}
            @if (! $existingRegistration && $competition->isRegistrationOpen())
                <section id="form-daftar-lomba" class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm p-5 sm:p-6">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div>
                            <h2 class="text-base sm:text-lg font-bold font-display text-slate-900">Formulir Pendaftaran {{ $competition->short_title }}</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Data biodata Anda otomatis terisi dari Profil Akun.</p>
                        </div>
                        <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full">
                            {{ $competition->isTeamCompetition() ? 'Pendaftaran Tim' : 'Pendaftaran Individu' }}
                        </span>
                    </div>

                    {{-- Auto-filled Profile Summary --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 mb-5 text-xs">
                        <div>
                            <span class="text-slate-400 block">Nama {{ $competition->isTeamCompetition() ? 'Ketua Tim' : 'Peserta' }}</span>
                            <strong class="text-slate-800">{{ $user->name }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Asal Sekolah & Jenjang</span>
                            <strong class="text-slate-800">{{ $user->school_name ?: '-' }} ({{ $user->education_level ?: '-' }})</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block">NISN & WhatsApp</span>
                            <strong class="text-slate-800">{{ $user->nisn ?: 'Belum diisi' }} • {{ $user->phone ?: '-' }}</strong>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('peserta.competitions.register', $competition) }}" class="space-y-4">
                        @csrf

                        @if (! empty($competition->branches))
                            <div>
                                <label for="branch" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Pilih Bidang / Cabang Lomba <span class="text-red-500">*</span>
                                </label>
                                <select id="branch"
                                        name="branch"
                                        required
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                                    <option value="">-- Pilih Bidang Lomba --</option>
                                    @foreach ($competition->branches as $branch)
                                        <option value="{{ $branch }}" {{ old('branch') === $branch ? 'selected' : '' }}>{{ $branch }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if ($competition->isTeamCompetition())
                            <div>
                                <label for="team_name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                    Nama Tim <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="team_name"
                                       name="team_name"
                                       value="{{ old('team_name') }}"
                                       required
                                       placeholder="Contoh: Tim Toba Inovatif"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                            </div>

                            <div class="space-y-2.5">
                                <p class="text-xs font-semibold text-slate-700">
                                    Anggota Tim Tambahan <span class="text-slate-400 font-normal">(Opsional, maksimal {{ max(0, $competition->max_team_members - 1) }} anggota)</span>
                                </p>
                                @for ($i = 0; $i < max(0, $competition->max_team_members - 1); $i++)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <input type="text"
                                               name="member_names[]"
                                               value="{{ old('member_names.'.$i) }}"
                                               placeholder="Nama Anggota {{ $i + 2 }}"
                                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                                        <input type="text"
                                               name="member_nisns[]"
                                               value="{{ old('member_nisns.'.$i) }}"
                                               placeholder="NISN / NIM Anggota {{ $i + 2 }}"
                                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                                    </div>
                                @endfor
                            </div>
                        @endif

                        <label class="flex items-start gap-2.5 text-xs text-slate-600 cursor-pointer pt-1">
                            <input type="checkbox"
                                   name="agree_rules"
                                   value="1"
                                   required
                                   class="mt-0.5 w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span>Saya menyatakan biodata di atas benar dan bersedia mematuhi seluruh tata tertib serta jadwal {{ $competition->short_title }}.</span>
                        </label>

                        <div class="pt-2 flex flex-wrap items-center justify-between gap-3">
                            <a href="{{ route('peserta.profile') }}" class="text-xs font-medium text-slate-500 hover:text-blue-600 underline">
                                Ubah biodata profil?
                            </a>
                            <button type="submit"
                                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm shadow-blue-600/20 transition cursor-pointer">
                                Konfirmasi Pendaftaran Lomba
                            </button>
                        </div>
                    </form>
                </section>
            @endif
        </div>

        {{-- Right Column (4 cols): Sticky Registration Summary Card --}}
        <aside class="lg:col-span-4 space-y-5 lg:sticky lg:top-24">
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-5 sm:p-6">
                <div class="inline-block text-[11px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg mb-2">
                    Biaya Registrasi
                </div>
                <div class="flex items-baseline gap-1.5 mb-5">
                    <span class="text-2xl font-extrabold font-display text-slate-900">
                        {{ $competition->registration_fee === 0 ? 'Gratis' : 'Rp '.number_format($competition->registration_fee, 0, ',', '.') }}
                    </span>
                    @if ($competition->registration_fee > 0)
                        <span class="text-xs text-slate-500">/ {{ $competition->fee_unit }}</span>
                    @endif
                </div>

                <div class="space-y-3 text-xs border-y border-slate-100 py-4 mb-5">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Tipe Lomba</span>
                        <strong class="text-slate-800">{{ $competition->isTeamCompetition() ? 'Tim (1–'.$competition->max_team_members.' Org)' : 'Individu' }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Jenjang Peserta</span>
                        <strong class="text-slate-800 text-right">{{ $competition->education_label }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Batas Daftar</span>
                        <strong class="text-slate-800">{{ $competition->registration_end?->translatedFormat('d M Y') }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Pelaksanaan</span>
                        <strong class="text-blue-700">{{ $competition->event_date?->translatedFormat('d M Y') }}</strong>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-slate-500">Kuota Tersisa</span>
                            <strong class="text-slate-800">{{ $remainingQuota }} / {{ $competition->quota }} Peserta</strong>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-blue-600" style="width: {{ max(8, $quotaPercentage) }}%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-1">
                        <span class="text-slate-500">Total Hadiah</span>
                        <strong class="text-emerald-600 text-right">{{ $competition->total_prize_summary }}</strong>
                    </div>
                </div>

                <div class="space-y-2.5">
                    @if ($existingRegistration)
                        <a href="{{ route('peserta.registrations.index') }}"
                           class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-xs transition">
                            Lihat Status Pendaftaran Saya
                        </a>
                    @elseif ($competition->isRegistrationOpen())
                        <a href="#form-daftar-lomba"
                           class="w-full inline-flex items-center justify-center py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm shadow-blue-600/20 transition">
                            Daftar Lomba Ini Sekarang
                        </a>
                    @else
                        <button type="button" disabled
                                class="w-full py-3 px-4 rounded-xl bg-slate-200 text-slate-500 text-sm font-semibold cursor-not-allowed">
                            Pendaftaran Ditutup
                        </button>
                    @endif

                    @if ($competition->group_link)
                        <a href="{{ $competition->group_link }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/40 text-slate-700 text-xs font-semibold transition">
                            <span>Gabung Grup Informasi (WA)</span>
                        </a>
                    @endif
                </div>

                <p class="text-[11px] text-slate-400 text-center mt-3.5">
                    Biodata Anda akan terisi otomatis dari Profil Akun.
                </p>

                @if ($competition->contact_person)
                    <div class="mt-4 pt-3.5 border-t border-slate-100 text-[11px] text-slate-500 text-center">
                        Kontak Panitia: <strong class="text-slate-700">{{ $competition->contact_person }}</strong>
                    </div>
                @endif
            </div>

            @if ($competitionAnnouncements->isNotEmpty())
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5">
                    <h3 class="text-sm font-bold font-display text-slate-900 mb-3">Info Khusus {{ $competition->short_title }}</h3>
                    <div class="space-y-2.5">
                        @foreach ($competitionAnnouncements as $ann)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <p class="text-xs font-semibold text-slate-800">{{ $ann->title }}</p>
                                <p class="text-[11px] text-slate-500 mt-1">{{ $ann->body }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>

    {{-- Modal Buku Panduan Ringkas --}}
    <div id="guidebook-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 relative">
            <button type="button"
                    onclick="document.getElementById('guidebook-modal').classList.add('hidden')"
                    class="absolute top-4 right-4 p-1.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full mb-2">
                Ringkasan Guidebook
            </span>
            <h3 class="text-lg font-bold font-display text-slate-900">Buku Panduan {{ $competition->short_title }}</h3>
            <p class="text-xs text-slate-500 mt-1 mb-4">{{ $competition->organizer }}</p>
            <div class="space-y-3 text-xs text-slate-600 bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p><strong>1. Mekanisme:</strong> Peserta mendaftar melalui akun Del Olympic, mengunggah bukti pembayaran serta kartu pelajar/surat rekomendasi, lalu menunggu verifikasi panitia.</p>
                <p><strong>2. Pelaksanaan:</strong> Peserta terverifikasi wajib mengunduh Kartu Peserta dan mengikuti Technical Meeting pada <strong>{{ $competition->technical_meeting_date?->translatedFormat('d M Y') }}</strong>.</p>
                <p><strong>3. Kisi-Kisi Utama:</strong> {{ implode(', ', $competition->syllabus ?? []) }}.</p>
            </div>
            <div class="mt-5 flex justify-end gap-2">
                <button type="button"
                        onclick="window.print()"
                        class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-semibold text-slate-700 cursor-pointer">
                    Cetak Ringkasan
                </button>
                <button type="button"
                        onclick="document.getElementById('guidebook-modal').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold cursor-pointer">
                    Mengerti
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function switchDetailTab(tabName) {
        document.querySelectorAll('.detail-tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
        document.querySelectorAll('.detail-tab-btn').forEach(btn => {
            btn.classList.remove('border-blue-600', 'text-blue-600', 'font-semibold');
            btn.classList.add('border-transparent', 'text-slate-500', 'font-medium');
        });

        const activePanel = document.getElementById('tab-panel-' + tabName);
        const activeBtn = document.getElementById('tab-btn-' + tabName);
        if (activePanel) {
            activePanel.classList.remove('hidden');
        }
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-slate-500', 'font-medium');
            activeBtn.classList.add('border-blue-600', 'text-blue-600', 'font-semibold');
        }
    }
</script>
@endpush
