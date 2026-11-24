@extends('layouts.peserta')

@section('title', 'Lomba Saya')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold font-display text-slate-900">Lomba Saya</h1>
            <p class="text-sm text-slate-500 mt-1">
                Pantau tahapan pendaftaran, unggah bukti pembayaran & berkas persyaratan, serta cetak Kartu Peserta.
            </p>
        </div>
        <a href="{{ route('peserta.competitions.index') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold shadow-2xs transition">
            <span>+ Daftar Lomba Lain</span>
        </a>
    </div>

    @if ($registrations->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h2 class="text-base font-bold font-display text-slate-900">Belum Ada Pendaftaran Lomba</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-md mx-auto">
                Anda belum mendaftar ke kompetisi mana pun. Mulai dengan menjelajahi daftar lomba resmi Del Olympic.
            </p>
            <a href="{{ route('peserta.competitions.index') }}"
               class="inline-flex items-center mt-5 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold transition">
                Jelajah Lomba Sekarang
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($registrations as $reg)
                @php
                    $step = $reg->progressStep();
                    $steps = ['1. Pendaftaran', '2. Unggah Berkas & Bayar', '3. Verifikasi Panitia', '4. Kartu Peserta'];
                @endphp

                <article id="upload-{{ $reg->id }}" class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
                    {{-- Header --}}
                    <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $reg->statusBadgeClasses() }}">
                                    {{ $reg->statusLabel() }}
                                </span>
                                <span class="text-xs font-mono font-semibold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                    {{ $reg->registration_number }}
                                </span>
                                @if ($reg->branch)
                                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full">
                                        {{ $reg->branch }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-lg font-bold font-display text-slate-900">
                                <a href="{{ route('peserta.competitions.show', $reg->competition) }}" class="hover:text-blue-600 transition">
                                    {{ $reg->competition->short_title }} — {{ $reg->competition->title }}
                                </a>
                            </h2>
                            <p class="text-xs text-slate-500 mt-1">
                                Penyelenggara: {{ $reg->competition->organizer }}
                                • Biaya: <strong class="text-slate-700">{{ $reg->competition->formattedFee() }}</strong>
                                • Pelaksanaan: <strong class="text-blue-700">{{ $reg->competition->event_date?->translatedFormat('d M Y') }}</strong>
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2.5 flex-shrink-0">
                            <a href="{{ route('peserta.competitions.show', $reg->competition) }}"
                               class="px-4 py-2 rounded-xl border border-slate-200 hover:border-blue-300 text-slate-700 text-xs font-semibold transition">
                                Detail Lomba
                            </a>
                            @if ($reg->isVerified())
                                <a href="{{ route('peserta.registrations.card', $reg) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-2xs transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                    <span>Cetak Kartu Peserta</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Progress Stepper --}}
                    <div class="px-5 sm:px-6 py-4 bg-slate-50/70 border-b border-slate-100">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach ($steps as $idx => $label)
                                @php
                                    $stepNum = $idx + 1;
                                    $isDone = $step > $stepNum || ($step === 4 && $stepNum === 4);
                                    $isCurrent = $step === $stepNum && ! $isDone;
                                @endphp
                                <div class="flex flex-col gap-1.5">
                                    <div class="h-2 rounded-full {{ $isDone ? 'bg-emerald-500' : ($isCurrent ? 'bg-blue-600' : 'bg-slate-200') }}"></div>
                                    <span class="text-xs font-medium {{ $isDone ? 'text-emerald-700 font-semibold' : ($isCurrent ? 'text-blue-700 font-semibold' : 'text-slate-400') }}">
                                        {{ $isDone ? '✓ ' : ($isCurrent ? '● ' : '') }}{{ $label }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Body Details --}}
                    <div class="p-5 sm:p-6 space-y-5">
                        {{-- Catatan Panitia --}}
                        @if ($reg->admin_notes)
                            <div class="p-3.5 rounded-xl border text-xs leading-relaxed {{ $reg->status === 'revisi' ? 'bg-orange-50 border-orange-200 text-orange-800' : ($reg->isVerified() ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-blue-50 border-blue-100 text-blue-800') }}">
                                <strong class="block mb-0.5">Catatan Panitia:</strong>
                                {{ $reg->admin_notes }}
                            </div>
                        @endif

                        {{-- Info Tim (Jika Lomba Tim) --}}
                        @if ($reg->team_name)
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/70">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Data Tim</h3>
                                    <span class="text-xs font-bold text-slate-900">{{ $reg->team_name }}</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                                    <div class="p-2.5 rounded-lg bg-white border border-slate-200/70">
                                        <span class="text-[10px] font-semibold uppercase text-blue-600 block">Ketua Tim</span>
                                        <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                                    </div>
                                    @foreach ($reg->team_members ?? [] as $idx => $member)
                                        <div class="p-2.5 rounded-lg bg-white border border-slate-200/70">
                                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Anggota {{ $idx + 2 }}</span>
                                            <span class="font-semibold text-slate-800">{{ $member['name'] ?? '-' }}</span>
                                            @if (! empty($member['nisn']))
                                                <span class="block text-[11px] text-slate-400">NISN/NIM: {{ $member['nisn'] }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Status Berkas Terunggah --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                            <div class="p-3 rounded-xl border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 block">Bukti Pembayaran</span>
                                    <strong class="{{ $reg->payment_proof_path || $reg->isVerified() ? 'text-emerald-700' : 'text-amber-700' }}">
                                        {{ $reg->payment_proof_path ? 'Sudah Diunggah' : ($reg->isVerified() ? 'Terverifikasi' : 'Belum Diunggah') }}
                                    </strong>
                                </div>
                                @if ($reg->payment_proof_path)
                                    <a href="{{ asset('storage/'.$reg->payment_proof_path) }}" target="_blank" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                                @endif
                            </div>

                            <div class="p-3 rounded-xl border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 block">Kartu Pelajar / KTM</span>
                                    <strong class="{{ $reg->student_card_path || $reg->isVerified() ? 'text-emerald-700' : 'text-slate-600' }}">
                                        {{ $reg->student_card_path ? 'Sudah Diunggah' : ($reg->isVerified() ? 'Terverifikasi' : 'Belum Diunggah') }}
                                    </strong>
                                </div>
                                @if ($reg->student_card_path)
                                    <a href="{{ asset('storage/'.$reg->student_card_path) }}" target="_blank" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                                @endif
                            </div>

                            <div class="p-3 rounded-xl border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="text-slate-400 block">Surat Rekomendasi</span>
                                    <strong class="{{ $reg->recommendation_letter_path || $reg->isVerified() ? 'text-emerald-700' : 'text-slate-600' }}">
                                        {{ $reg->recommendation_letter_path ? 'Sudah Diunggah' : ($reg->isVerified() ? 'Terverifikasi' : 'Opsional / Belum') }}
                                    </strong>
                                </div>
                                @if ($reg->recommendation_letter_path)
                                    <a href="{{ asset('storage/'.$reg->recommendation_letter_path) }}" target="_blank" class="text-blue-600 font-semibold hover:underline">Lihat</a>
                                @endif
                            </div>
                        </div>

                        {{-- Form Upload Bukti Pembayaran & Berkas (jika belum terverifikasi) --}}
                        @if (! $reg->isVerified())
                            <form method="POST"
                                  action="{{ route('peserta.registrations.upload', $reg) }}"
                                  enctype="multipart/form-data"
                                  class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                                @csrf
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div>
                                        <h3 class="text-sm font-bold font-display text-slate-900">Unggah Bukti Pembayaran & Berkas</h3>
                                        <p class="text-xs text-slate-500">Format JPG, PNG, atau PDF (maks. 4 MB). Rekening BNI Del Olympic: <strong>0812-3456-7890</strong>.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="payment_proof_{{ $reg->id }}" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Bukti Transfer ({{ $reg->competition->formattedFee() }})
                                        </label>
                                        <input type="file"
                                               id="payment_proof_{{ $reg->id }}"
                                               name="payment_proof"
                                               accept=".jpg,.jpeg,.png,.pdf"
                                               class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-slate-200 rounded-xl p-1.5">
                                    </div>

                                    <div>
                                        <label for="student_card_{{ $reg->id }}" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Scan Kartu Pelajar / KTM
                                        </label>
                                        <input type="file"
                                               id="student_card_{{ $reg->id }}"
                                               name="student_card"
                                               accept=".jpg,.jpeg,.png,.pdf"
                                               class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 bg-white border border-slate-200 rounded-xl p-1.5">
                                    </div>

                                    <div>
                                        <label for="recommendation_letter_{{ $reg->id }}" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Surat Rekomendasi Sekolah
                                        </label>
                                        <input type="file"
                                               id="recommendation_letter_{{ $reg->id }}"
                                               name="recommendation_letter"
                                               accept=".jpg,.jpeg,.png,.pdf"
                                               class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 bg-white border border-slate-200 rounded-xl p-1.5">
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold shadow-2xs transition cursor-pointer">
                                        Kirim Berkas untuk Verifikasi
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
