@extends('layouts.peserta')

@section('title', 'Jadwal & Pengumuman')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold font-display text-slate-900">Jadwal & Pengumuman</h1>
        <p class="text-sm text-slate-500 mt-1">
            Pantau seluruh agenda penting, akses ruang ujian CBT, dan informasi resmi dari panitia Del Olympic.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- Kolom Kiri: Agenda & Akses Pelaksanaan --}}
        <div class="lg:col-span-7 space-y-6">
            {{-- Akses Cepat Pelaksanaan Ujian / Submission --}}
            @php
                $verifiedRegs = $registrations->filter(fn ($r) => $r->isVerified());
            @endphp
            @if ($verifiedRegs->isNotEmpty())
                <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                    <h2 class="text-base font-bold font-display text-slate-900 mb-3">Akses Pelaksanaan Lomba Terverifikasi</h2>
                    <div class="space-y-3">
                        @foreach ($verifiedRegs as $reg)
                            <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $reg->competition->short_title }} — {{ $reg->branch ?: $reg->competition->category_label }}</p>
                                    <p class="text-xs text-slate-600 mt-0.5">
                                        Jadwal Penyisihan: <strong>{{ $reg->competition->event_date?->translatedFormat('d M Y') }}</strong>
                                        • No. Peserta: <span class="font-mono font-semibold">{{ $reg->registration_number }}</span>
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @if ($reg->competition->group_link)
                                        <a href="{{ $reg->competition->group_link }}" target="_blank" rel="noopener noreferrer"
                                           class="px-3.5 py-2 rounded-xl bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 text-xs font-semibold transition">
                                            Grup WA
                                        </a>
                                    @endif
                                    <a href="{{ route('peserta.registrations.card', $reg) }}"
                                       class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition">
                                        Kartu Peserta
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Timeline Jadwal Mendatang --}}
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                <h2 class="text-base font-bold font-display text-slate-900 mb-4">Timeline Jadwal Kompetisi</h2>

                @if ($schedules->isEmpty())
                    <p class="text-xs text-slate-500 py-6 text-center">Belum ada jadwal kompetisi yang tercatat.</p>
                @else
                    <div class="space-y-3.5">
                        @foreach ($schedules as $item)
                            <div class="flex items-start gap-4 p-3.5 rounded-2xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 transition">
                                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex flex-col items-center justify-center flex-shrink-0 leading-none shadow-xs">
                                    <span class="text-base font-extrabold font-display">{{ $item['day_label'] }}</span>
                                    <span class="text-[10px] font-semibold uppercase mt-0.5 text-blue-100">{{ $item['month_label'] }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('peserta.competitions.show', $item['competition_slug']) }}"
                                           class="text-sm font-bold text-slate-900 hover:text-blue-600 transition">
                                            {{ $item['title'] }}
                                        </a>
                                        @if ($item['is_joined'])
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">Lomba Anda</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $item['full_date'] }}
                                        @if ($item['days_left'] > 0)
                                            • <span class="text-blue-600 font-semibold">{{ $item['days_left'] }} hari lagi</span>
                                        @elseif ($item['days_left'] === 0)
                                            • <span class="text-emerald-600 font-bold">Hari ini</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        {{-- Kolom Kanan: Pusat Pengumuman Panitia --}}
        <div id="pengumuman" class="lg:col-span-5">
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold font-display text-slate-900">Pengumuman Resmi Panitia</h2>
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full">{{ $announcements->count() }} Info</span>
                </div>

                <div class="space-y-3.5">
                    @forelse ($announcements as $ann)
                        <article class="p-4 rounded-2xl border {{ $ann->is_pinned ? 'bg-blue-50/50 border-blue-200' : 'bg-slate-50/70 border-slate-200/70' }}">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $ann->category === 'penting' ? 'bg-blue-600 text-white' : ($ann->category === 'jadwal' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-700') }}">
                                        {{ $ann->categoryLabel() }}
                                    </span>
                                    @if ($ann->competition)
                                        <span class="text-[11px] font-semibold text-slate-500">{{ $ann->competition->short_title }}</span>
                                    @else
                                        <span class="text-[11px] font-semibold text-slate-500">Umum</span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-slate-400">{{ $ann->published_at?->diffForHumans() }}</span>
                            </div>

                            <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $ann->title }}</h3>
                            <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $ann->body }}</p>
                        </article>
                    @empty
                        <p class="text-xs text-slate-500 py-6 text-center">Belum ada pengumuman resmi.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
