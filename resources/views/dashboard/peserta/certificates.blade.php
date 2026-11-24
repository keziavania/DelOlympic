@extends('layouts.peserta')

@section('title', 'Sertifikat & Hasil')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold font-display text-slate-900">Sertifikat & Hasil Lomba</h1>
        <p class="text-sm text-slate-500 mt-1">
            Lihat hasil pencapaian kompetisi Anda dan cetak E-Sertifikat resmi Del Olympic.
        </p>
    </div>

    @if ($registrations->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <h2 class="text-base font-bold font-display text-slate-800">Belum Ada Riwayat Hasil atau Sertifikat</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 mb-5">Daftar dan ikuti kompetisi Del Olympic untuk mendapatkan E-Sertifikat resmi bernomor verifikasi.</p>
            <a href="{{ route('peserta.competitions.index') }}"
               class="inline-flex items-center px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold transition">
                Jelajah Lomba
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($registrations as $reg)
                <article class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $reg->statusBadgeClasses() }}">
                                {{ $reg->statusLabel() }}
                            </span>
                            @if ($reg->certificate_code)
                                <span class="text-[11px] font-mono text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                    {{ $reg->certificate_code }}
                                </span>
                            @endif
                        </div>

                        <h2 class="text-lg font-bold font-display text-slate-900">{{ $reg->competition->short_title }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $reg->branch ?: $reg->competition->category_label }} • {{ $reg->competition->organizer }}</p>

                        <div class="mt-4 p-4 rounded-xl bg-slate-50 border border-slate-100 grid grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block">Capaian / Status Hasil</span>
                                <strong class="text-slate-900">{{ $reg->resultLabel() }}</strong>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Nilai / Skor Akhir</span>
                                <strong class="text-blue-700">{{ $reg->score !== null ? number_format((float) $reg->score, 2) : 'Menunggu Rilis' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        @if ($reg->isVerified())
                            <button type="button"
                                    onclick="openCertificatePreview('{{ addslashes($user->name) }}', '{{ addslashes($user->school_name ?: '-') }}', '{{ addslashes($reg->competition->title) }}', '{{ addslashes($reg->branch ?: $reg->competition->category_label) }}', '{{ addslashes($reg->resultLabel()) }}', '{{ addslashes($reg->certificate_code ?: $reg->registration_number) }}')"
                                    class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold transition cursor-pointer">
                                Pratinjau & Cetak E-Sertifikat
                            </button>
                        @else
                            <a href="{{ route('peserta.registrations.index') }}#upload-{{ $reg->id }}"
                               class="w-full text-center py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                                Selesaikan Verifikasi untuk Membuka Sertifikat
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    {{-- Modal Pratinjau E-Sertifikat --}}
    <div id="certificate-modal" class="fixed inset-0 z-50 hidden bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl relative">
            <button type="button"
                    onclick="document.getElementById('certificate-modal').classList.add('hidden')"
                    class="absolute top-4 right-4 p-2 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="border-4 border-double border-blue-800 rounded-2xl p-6 sm:p-10 text-center bg-gradient-to-b from-blue-50/40 via-white to-amber-50/30">
                <img src="{{ asset('images/logo.png') }}" alt="Del Olympic" class="h-12 w-auto mx-auto mb-3">
                <p class="text-xs uppercase tracking-[0.25em] font-bold text-blue-700">Sertifikat Penghargaan Resmi</p>
                <p id="cert-code" class="text-[11px] font-mono text-slate-400 mt-1"></p>

                <p class="text-xs text-slate-500 mt-5">Diberikan kepada:</p>
                <h3 id="cert-name" class="text-2xl sm:text-3xl font-extrabold font-display text-slate-900 mt-1"></h3>
                <p id="cert-school" class="text-sm font-medium text-slate-600 mt-1"></p>

                <p class="text-xs text-slate-500 mt-5">Atas partisipasi dan pencapaiannya sebagai</p>
                <p id="cert-result" class="text-base font-bold text-blue-700 mt-1"></p>
                <p class="text-xs text-slate-600 mt-2">
                    Pada ajang <strong id="cert-comp"></strong> — Bidang <strong id="cert-branch"></strong>
                </p>

                <div class="mt-8 pt-4 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-500">
                    <span>Institut Teknologi Del — Laguboti</span>
                    <span class="font-semibold text-emerald-700">✓ Terverifikasi Digital Del Olympic</span>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <button type="button"
                        onclick="document.getElementById('certificate-modal').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">
                    Tutup
                </button>
                <button type="button"
                        onclick="window.print()"
                        class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold cursor-pointer">
                    Cetak / Simpan PDF
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openCertificatePreview(name, school, competition, branch, result, code) {
        document.getElementById('cert-name').textContent = name;
        document.getElementById('cert-school').textContent = school;
        document.getElementById('cert-comp').textContent = competition;
        document.getElementById('cert-branch').textContent = branch;
        document.getElementById('cert-result').textContent = result;
        document.getElementById('cert-code').textContent = 'No. Sertifikat: ' + code;
        document.getElementById('certificate-modal').classList.remove('hidden');
    }
</script>
@endpush
