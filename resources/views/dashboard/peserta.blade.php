@extends('layouts.peserta')

@section('title', 'Beranda Dashboard Peserta')

@section('content')
    {{-- Banner Pengingat Lengkapi Profil --}}
    @if (! $user->isParticipantProfileComplete())
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-amber-900">Biodata profil Anda belum lengkap</p>
                    <p class="text-xs text-amber-700 mt-0.5">Lengkapi NISN, kelas, dan data sekolah agar formulir pendaftaran lomba, kartu peserta, dan E-Sertifikat terisi otomatis.</p>
                </div>
            </div>
            <a href="{{ route('peserta.profile') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold transition flex-shrink-0">
                Lengkapi Profil
            </a>
        </div>
    @endif

    {{-- Welcome Hero Banner --}}
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#1660eb] via-blue-600 to-sky-500 text-white p-6 sm:p-7 shadow-md shadow-blue-600/15 mb-6">
        <div class="absolute -right-10 -top-10 w-44 h-44 rounded-full bg-white/10 pointer-events-none"></div>
        <div class="absolute right-16 -bottom-14 w-32 h-32 rounded-full bg-sky-300/20 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold font-display tracking-tight">
                    Selamat Datang, {{ $user->name }}!
                </h1>
                <p class="text-blue-100 text-xs sm:text-sm mt-1.5 flex flex-wrap items-center gap-x-2 gap-y-1">
                    <span>{{ $user->school_name ?: 'Asal sekolah belum diisi' }}</span>
                    @if ($user->grade || $user->education_level)
                        <span>•</span>
                        <span>{{ trim(($user->grade ? $user->grade.' ' : '').($user->education_level ? '('.$user->education_level.')' : '')) }}</span>
                    @endif
                    <span>•</span>
                    <a href="{{ route('peserta.profile') }}" class="underline decoration-blue-200/80 hover:text-white font-medium">
                        {{ $user->isParticipantProfileComplete() ? 'Profil Lengkap' : 'Lengkapi Profil' }}
                    </a>
                </p>
            </div>
            <a href="{{ route('peserta.competitions.index') }}"
               class="inline-flex items-center justify-center gap-2 bg-white hover:bg-blue-50 text-blue-700 font-semibold text-xs sm:text-sm px-5 py-2.5 rounded-xl shadow-sm transition flex-shrink-0">
                <span>Jelajah Lomba</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- 4 KPI Summary Cards --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        {{-- Card 1: Lomba Diikuti --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Lomba Diikuti</p>
                <p class="text-2xl font-extrabold font-display text-slate-900 leading-tight mt-0.5">{{ $registrations->count() }}</p>
            </div>
        </div>

        {{-- Card 2: Status Verifikasi --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-slate-500">Status Verifikasi</p>
                @if ($verifiedCount > 0)
                    <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                        {{ $verifiedCount }} Terverifikasi
                    </span>
                @elseif ($actionNeededCount > 0)
                    <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                        {{ $actionNeededCount }} Perlu Aksi
                    </span>
                @elseif ($pendingVerifyCount > 0)
                    <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                        {{ $pendingVerifyCount }} Diproses
                    </span>
                @else
                    <p class="text-sm font-bold text-slate-700 mt-1">Belum Daftar</p>
                @endif
            </div>
        </div>

        {{-- Card 3: Jadwal Terdekat --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-slate-500">Jadwal Terdekat</p>
                @if ($nearestSchedule)
                    <p class="text-lg font-extrabold font-display text-slate-900 leading-tight mt-0.5">
                        @if ($nearestSchedule['days_left'] > 0)
                            {{ $nearestSchedule['days_left'] }} Hari Lagi
                        @elseif ($nearestSchedule['days_left'] === 0)
                            Hari Ini
                        @else
                            {{ $nearestSchedule['full_date'] }}
                        @endif
                    </p>
                    <p class="text-[11px] text-slate-500 truncate">{{ $nearestSchedule['competition_title'] }}</p>
                @else
                    <p class="text-sm font-bold text-slate-700 mt-1">Belum Ada</p>
                @endif
            </div>
        </div>

        {{-- Card 4: Pengumuman --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-500">Pengumuman</p>
                <p class="text-xl font-extrabold font-display text-slate-900 leading-tight mt-0.5">{{ $announcementCount }} Info</p>
            </div>
        </div>
    </section>

    {{-- Main Two-Column Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Left Column (8 cols) --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Lomba Saya (Status Pendaftaran) --}}
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold font-display text-slate-900">Lomba Saya (Status Pendaftaran)</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Pantau progres berkas, verifikasi panitia, dan kartu peserta Anda.</p>
                    </div>
                    <a href="{{ route('peserta.registrations.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                        Lihat Semua →
                    </a>
                </div>

                @if ($registrations->isEmpty())
                    <div class="text-center py-8 px-4 rounded-2xl bg-slate-50 border border-dashed border-slate-200">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800">Anda belum mendaftar kompetisi apa pun</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            Jelajahi daftar kompetisi resmi Del Olympic, pelajari silabus dan jadwalnya secara lengkap, lalu daftarkan diri Anda.
                        </p>
                        <a href="{{ route('peserta.competitions.index') }}"
                           class="inline-flex items-center gap-1.5 mt-4 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition">
                            Jelajah Lomba Sekarang
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($registrations->take(3) as $reg)
                            @php
                                $step = $reg->progressStep();
                                $steps = ['Daftar', 'Bayar & Berkas', 'Verifikasi', 'Kartu Peserta'];
                            @endphp
                            <div class="py-4 first:pt-0 last:pb-0">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <a href="{{ route('peserta.competitions.show', $reg->competition) }}"
                                               class="text-sm font-bold text-slate-900 hover:text-blue-600 transition">
                                                {{ $reg->competition->short_title }} — {{ $reg->branch ?: $reg->competition->category_label }}
                                            </a>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $reg->statusBadgeClasses() }}">
                                                {{ $reg->statusLabel() }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-500 mt-1">
                                            No. Registrasi: <span class="font-mono font-semibold text-slate-700">{{ $reg->registration_number }}</span>
                                            @if ($reg->team_name)
                                                • Tim: <span class="font-medium text-slate-700">{{ $reg->team_name }}</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="flex-shrink-0">
                                        @if ($reg->isVerified())
                                            <a href="{{ route('peserta.registrations.card', $reg) }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-blue-200 bg-blue-50/50 hover:bg-blue-50 text-blue-700 text-xs font-semibold transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                <span>Kartu Peserta</span>
                                            </a>
                                        @elseif (in_array($reg->status, ['menunggu_pembayaran', 'revisi'], true))
                                            <a href="{{ route('peserta.registrations.index') }}#upload-{{ $reg->id }}"
                                               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                </svg>
                                                <span>Unggah Bukti Bayar</span>
                                            </a>
                                        @else
                                            <a href="{{ route('peserta.registrations.index') }}"
                                               class="inline-flex items-center px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                                                Lihat Detail
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- 4-Step Progress Stepper --}}
                                <div class="mt-3.5 grid grid-cols-4 gap-2">
                                    @foreach ($steps as $idx => $label)
                                        @php
                                            $stepNum = $idx + 1;
                                            $isDone = $step > $stepNum || ($step === 4 && $stepNum === 4);
                                            $isCurrent = $step === $stepNum && ! $isDone;
                                        @endphp
                                        <div class="flex flex-col gap-1">
                                            <div class="h-1.5 rounded-full {{ $isDone ? 'bg-emerald-500' : ($isCurrent ? 'bg-blue-600' : 'bg-slate-200') }}"></div>
                                            <span class="text-[11px] font-medium truncate {{ $isDone ? 'text-emerald-700' : ($isCurrent ? 'text-blue-700 font-semibold' : 'text-slate-400') }}">
                                                {{ $isDone ? '✓ ' : ($isCurrent ? '● ' : '') }}{{ $label }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- Rekomendasi Lomba (Sesuai Jenjang) --}}
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold font-display text-slate-900">
                            Rekomendasi Lomba
                            @if ($user->education_level)
                                <span class="text-blue-600">(Jenjang {{ $user->education_level }})</span>
                            @endif
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Lihat detail menyeluruh silabus, jadwal, dan syarat sebelum mendaftar.</p>
                    </div>
                    <a href="{{ route('peserta.competitions.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                        Semua Lomba →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($recommendedCompetitions as $comp)
                        <div class="rounded-2xl border border-slate-200/90 p-4 hover:border-blue-300 hover:shadow-sm transition flex flex-col justify-between bg-slate-50/40">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
                                        {{ $comp->statusLabel() }}
                                    </span>
                                    <span class="text-[11px] font-semibold text-slate-500 bg-white border border-slate-200 px-2 py-0.5 rounded-full">
                                        {{ $comp->isTeamCompetition() ? 'Tim 1–'.$comp->max_team_members.' Orang' : 'Individu' }}
                                    </span>
                                </div>
                                <h3 class="text-sm font-bold font-display text-slate-900">{{ $comp->short_title }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $comp->title }}</p>
                                <div class="mt-3 flex items-center justify-between text-xs pt-2.5 border-t border-slate-200/70">
                                    <span class="font-bold text-blue-700">{{ $comp->formattedFee() }}</span>
                                    <span class="text-slate-500">Batas {{ $comp->registration_end?->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mt-4">
                                <a href="{{ route('peserta.competitions.show', $comp) }}"
                                   class="text-center py-2 px-3 rounded-xl border border-slate-200 bg-white hover:border-blue-400 hover:text-blue-700 text-slate-700 text-xs font-semibold transition">
                                    Detail Lengkap
                                </a>
                                <a href="{{ route('peserta.competitions.show', $comp) }}#form-daftar-lomba"
                                   class="text-center py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition">
                                    Daftar
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- Right Column (4 cols) --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Jadwal Mendatang --}}
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold font-display text-slate-900">Jadwal Mendatang</h2>
                    <a href="{{ route('peserta.schedule') }}" class="text-xs font-semibold text-blue-600 hover:underline">Lihat</a>
                </div>

                @if ($upcomingSchedules->isEmpty())
                    <p class="text-xs text-slate-500 py-4 text-center">Belum ada jadwal terdekat.</p>
                @else
                    <div class="space-y-3.5">
                        @foreach ($upcomingSchedules as $item)
                            <a href="{{ route('peserta.competitions.show', $item['competition_slug']) }}"
                               class="flex items-start gap-3 group">
                                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 flex flex-col items-center justify-center flex-shrink-0 leading-none">
                                    <span class="text-sm font-extrabold font-display">{{ $item['day_label'] }}</span>
                                    <span class="text-[10px] font-semibold uppercase mt-0.5">{{ $item['month_label'] }}</span>
                                </div>
                                <div class="min-w-0 pt-0.5">
                                    <p class="text-xs font-semibold text-slate-800 group-hover:text-blue-600 transition leading-snug">
                                        {{ $item['title'] }}
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $item['full_date'] }}
                                        @if ($item['is_joined'])
                                            <span class="text-emerald-600 font-semibold">• Lomba Anda</span>
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- Pengumuman Terbaru --}}
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold font-display text-slate-900">Pengumuman Terbaru</h2>
                    <a href="{{ route('peserta.schedule') }}#pengumuman" class="text-xs font-semibold text-blue-600 hover:underline">Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse ($announcements->take(3) as $announcement)
                        <a href="{{ route('peserta.schedule') }}#pengumuman"
                           class="block p-3 rounded-xl border transition {{ $announcement->category === 'penting' ? 'bg-blue-50/70 border-blue-100 hover:border-blue-300' : 'bg-slate-50 border-slate-100 hover:border-slate-300' }}">
                            <div class="flex items-start gap-2.5">
                                <span class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ $announcement->category === 'penting' ? 'bg-blue-600' : ($announcement->category === 'jadwal' ? 'bg-amber-500' : 'bg-emerald-500') }}"></span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-slate-800 leading-snug">{{ $announcement->title }}</p>
                                    <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">{{ $announcement->body }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-slate-500 py-4 text-center">Belum ada pengumuman terbaru.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
