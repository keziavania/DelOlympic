@extends('layouts.peserta')

@section('title', 'Kartu Peserta — '.$registration->competition->short_title)

@push('styles')
<style>
    @media print {
        aside, header, .no-print {
            display: none !important;
        }
        main {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
        }
        .lg\:pl-64 {
            padding-left: 0 !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="no-print flex flex-wrap items-center justify-between gap-3 mb-6">
        <a href="{{ route('peserta.registrations.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 hover:text-blue-600 transition">
            ← Kembali ke Lomba Saya
        </a>
        <button type="button"
                onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <div class="max-w-2xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-lg overflow-hidden">
        {{-- Card Header --}}
        <div class="bg-gradient-to-r from-[#0b1c3d] via-blue-800 to-[#1660eb] text-white p-6 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="bg-white p-2 rounded-xl">
                    <img src="{{ asset('images/logo.png') }}" alt="Del Olympic" class="h-9 w-auto">
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-widest text-blue-200 font-semibold">Kartu Peserta Resmi</p>
                    <h1 class="text-lg sm:text-xl font-extrabold font-display">{{ $registration->competition->short_title }}</h1>
                    <p class="text-xs text-blue-100">{{ $registration->competition->organizer }}</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full bg-emerald-500 text-white text-xs font-bold shadow-xs">
                TERVERIFIKASI
            </span>
        </div>

        {{-- Card Body --}}
        <div class="p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-blue-50/70 border border-blue-100">
                <div>
                    <span class="text-[11px] uppercase tracking-wider font-semibold text-blue-600 block">Nomor Peserta / Ujian</span>
                    <span class="text-xl font-mono font-extrabold text-slate-900 tracking-wide">{{ $registration->registration_number }}</span>
                </div>
                <div class="sm:text-right">
                    <span class="text-[11px] uppercase tracking-wider font-semibold text-slate-500 block">Cabang / Bidang Lomba</span>
                    <span class="text-sm font-bold text-blue-700">{{ $registration->branch ?: $registration->competition->category_label }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs text-slate-400 block">Nama Lengkap Peserta</span>
                    <strong class="text-slate-900">{{ $user->name }}</strong>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs text-slate-400 block">NISN / Identitas</span>
                    <strong class="text-slate-900">{{ $user->nisn ?: '-' }}</strong>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs text-slate-400 block">Asal Sekolah / Institusi</span>
                    <strong class="text-slate-900">{{ $user->school_name ?: '-' }}</strong>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs text-slate-400 block">Jenjang & Kelas</span>
                    <strong class="text-slate-900">{{ trim(($user->education_level ?: '-').($user->grade ? ' • '.$user->grade : '')) }}</strong>
                </div>
                @if ($registration->team_name)
                    <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block">Nama Tim</span>
                        <strong class="text-slate-900">{{ $registration->team_name }}</strong>
                    </div>
                @endif
            </div>

            <div class="border-t border-dashed border-slate-200 pt-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-600">
                <div>
                    <span class="text-slate-400 block">Tanggal Technical Meeting</span>
                    <strong class="text-slate-800">{{ $registration->competition->technical_meeting_date?->translatedFormat('d M Y') ?: '-' }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block">Tanggal Pelaksanaan Babak Penyisihan</span>
                    <strong class="text-blue-700">{{ $registration->competition->event_date?->translatedFormat('d M Y') ?: '-' }}</strong>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-slate-900 text-slate-200 text-xs leading-relaxed">
                <strong class="text-white block mb-1">Tata Tertib Singkat Peserta:</strong>
                Tunjukkan kartu peserta ini saat verifikasi ruang ujian CBT atau registrasi ulang babak final di Kampus Institut Teknologi Del. Simpan nomor peserta Anda dengan baik.
            </div>
        </div>
    </div>
@endsection
