@extends('layouts.peserta')

@section('title', 'Jelajah Lomba')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold font-display text-slate-900">Jelajah Lomba</h1>
            <p class="text-sm text-slate-500 mt-1">
                Pilih kompetisi untuk melihat rincian silabus, timeline, syarat berkas, kuota, dan mendaftar langsung.
            </p>
        </div>
        <div class="text-xs font-medium text-slate-500 bg-white border border-slate-200 px-3.5 py-2 rounded-xl">
            Menampilkan <strong class="text-blue-700">{{ $competitions->count() }}</strong> kompetisi
        </div>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('peserta.competitions.index') }}"
          class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-4 sm:p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-end">
            <div class="md:col-span-4">
                <label for="q" class="block text-xs font-semibold text-slate-700 mb-1.5">Cari Kompetisi</label>
                <input type="text"
                       id="q"
                       name="q"
                       value="{{ $search }}"
                       placeholder="Ketik DMSC, POSI, Del Tech, sains..."
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            </div>

            <div class="md:col-span-3">
                <label for="kategori" class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                <select id="kategori"
                        name="kategori"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                    <option value="all" {{ $category === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="sains" {{ $category === 'sains' ? 'selected' : '' }}>Matematika & Sains</option>
                    <option value="olimpiade" {{ $category === 'olimpiade' ? 'selected' : '' }}>Olimpiade Nasional</option>
                    <option value="teknologi" {{ $category === 'teknologi' ? 'selected' : '' }}>Teknologi & IT</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="status" class="block text-xs font-semibold text-slate-700 mb-1.5">Status</label>
                <select id="status"
                        name="status"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-blue-500">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="buka" {{ $status === 'buka' ? 'selected' : '' }}>Dibuka</option>
                    <option value="segera" {{ $status === 'segera' ? 'selected' : '' }}>Segera</option>
                    <option value="tutup" {{ $status === 'tutup' ? 'selected' : '' }}>Ditutup</option>
                </select>
            </div>

            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit"
                        class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold transition cursor-pointer">
                    Terapkan Filter
                </button>
                <a href="{{ route('peserta.competitions.index') }}"
                   class="py-2.5 px-3.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs sm:text-sm font-semibold transition">
                    Reset
                </a>
            </div>
        </div>

        @if ($user->education_level)
            <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2">
                <label class="inline-flex items-center gap-2.5 text-xs font-medium text-slate-700 cursor-pointer select-none">
                    <input type="checkbox"
                           name="sesuai_jenjang"
                           value="1"
                           {{ $matchEducation ? 'checked' : '' }}
                           onchange="this.form.submit()"
                           class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Tampilkan khusus yang cocok untuk jenjang saya (<strong class="text-blue-700">{{ $user->education_level }}</strong>)</span>
                </label>
                <span class="text-[11px] text-slate-400">Klik "Detail Lengkap" untuk membaca silabus, syarat, dan jadwal penuh.</span>
            </div>
        @endif
    </form>

    {{-- Competition Cards Grid --}}
    @if ($competitions->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <h3 class="text-base font-bold font-display text-slate-800">Tidak ada kompetisi yang sesuai filter</h3>
            <p class="text-xs text-slate-500 mt-1 mb-4">Coba hapus kata kunci atau pilih kategori lain.</p>
            <a href="{{ route('peserta.competitions.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-semibold transition">
                Tampilkan Semua Lomba
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($competitions as $competition)
                @php
                    $userReg = $userRegistrations->get($competition->id);
                    $isEligible = $competition->supportsEducationLevel($user->education_level);
                    $remaining = max(0, $competition->quota - $competition->registrations_count);
                    $gradientClass = match ($competition->accent_color) {
                        'sky' => 'from-indigo-950/90 via-sky-900/45 to-transparent',
                        'teal' => 'from-teal-950/90 via-teal-900/45 to-transparent',
                        default => 'from-blue-950/90 via-blue-900/45 to-transparent',
                    };
                @endphp

                <article class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-lg transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                    <div>
                        {{-- Card Header --}}
                        <div class="relative h-44 bg-slate-900 overflow-hidden">
                            @if ($competition->theme_image)
                                <img src="{{ asset($competition->theme_image) }}"
                                     alt="{{ $competition->short_title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t {{ $gradientClass }}"></div>

                            <div class="absolute inset-0 p-4 flex flex-col justify-between z-10">
                                <div class="flex items-center justify-between gap-2">
                                    @if ($userReg)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white text-blue-700 shadow-xs">
                                            ✓ Sudah Terdaftar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500 text-white shadow-xs">
                                            {{ $competition->statusLabel() }}
                                        </span>
                                    @endif

                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white/20 text-white border border-white/30 backdrop-blur-xs">
                                        {{ $competition->category_label }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl bg-white/95 text-slate-900 flex items-center justify-center font-bold font-display text-sm shadow-sm">
                                        {{ $competition->icon_symbol }}
                                    </div>
                                    <div class="text-white">
                                        <div class="text-[10px] uppercase font-semibold tracking-wider text-blue-200">{{ $competition->subtitle }}</div>
                                        <div class="text-xl font-extrabold font-display leading-tight">{{ $competition->short_title }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-base font-bold font-display text-slate-900 group-hover:text-blue-600 transition">
                                    {{ $competition->title }}
                                </h3>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $competition->organizer }}</p>

                            @if ($user->education_level)
                                <div class="mt-2.5">
                                    @if ($isEligible)
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                                            ✓ Cocok untuk jenjang {{ $user->education_level }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                            Khusus {{ $competition->education_label }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mt-3 mb-4">
                                {{ $competition->description }}
                            </p>

                            <div class="space-y-2 pt-3 border-t border-slate-100 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Tipe & Peserta</span>
                                    <span class="font-semibold text-slate-800">{{ $competition->isTeamCompetition() ? 'Tim (1–'.$competition->max_team_members.' Org)' : 'Individu' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Batas Pendaftaran</span>
                                    <span class="font-semibold text-slate-800">{{ $competition->registration_end?->translatedFormat('d M Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Kuota Tersisa</span>
                                    <span class="font-semibold text-slate-800">{{ $remaining }} / {{ $competition->quota }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-500">Biaya Registrasi</span>
                                    <span class="font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">{{ $competition->formattedFee() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="px-5 pb-5 pt-0">
                        <div class="grid grid-cols-2 gap-2.5 pt-3.5 border-t border-slate-100">
                            <a href="{{ route('peserta.competitions.show', $competition) }}"
                               class="text-center py-2.5 px-3 rounded-xl border border-slate-200 hover:border-blue-400 hover:bg-blue-50 text-slate-700 hover:text-blue-700 text-xs font-semibold transition">
                                Detail Lengkap
                            </a>
                            @if ($userReg)
                                <a href="{{ route('peserta.registrations.index') }}"
                                   class="text-center py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition">
                                    Status Saya
                                </a>
                            @else
                                <a href="{{ route('peserta.competitions.show', $competition) }}#form-daftar-lomba"
                                   class="text-center py-2.5 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-2xs transition">
                                    Daftar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
