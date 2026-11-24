<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Competition;
use App\Models\CompetitionRegistration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PesertaDashboardController extends Controller
{
    /**
     * Halaman Beranda Dashboard Peserta (Ringkasan Personal).
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $registrations = $user->competitionRegistrations()
            ->with('competition')
            ->latest()
            ->get();

        $registeredIds = $registrations->pluck('competition_id')->all();

        $allCompetitions = Competition::withCount('registrations')
            ->orderByRaw("CASE WHEN status = 'buka' THEN 0 WHEN status = 'segera' THEN 1 ELSE 2 END")
            ->orderBy('registration_end')
            ->get();

        $recommendedCompetitions = $allCompetitions
            ->reject(fn (Competition $competition): bool => in_array($competition->id, $registeredIds, true))
            ->sortByDesc(fn (Competition $competition): int => $competition->supportsEducationLevel($user->education_level) ? 1 : 0)
            ->take(2)
            ->values();

        if ($recommendedCompetitions->isEmpty()) {
            $recommendedCompetitions = $allCompetitions->take(2)->values();
        }

        $verifiedCount = $registrations->where('status', 'terverifikasi')->count();
        $actionNeededCount = $registrations->whereIn('status', ['menunggu_pembayaran', 'revisi'])->count();
        $pendingVerifyCount = $registrations->where('status', 'menunggu_verifikasi')->count();

        $upcomingSchedules = $this->buildUpcomingSchedules($registrations, $allCompetitions);
        $nearestSchedule = $upcomingSchedules->first();

        $announcements = Announcement::with('competition')
            ->where(function ($query) use ($registeredIds): void {
                $query->whereNull('competition_id');
                if (! empty($registeredIds)) {
                    $query->orWhereIn('competition_id', $registeredIds);
                }
            })
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('dashboard.peserta', [
            'user' => $user,
            'registrations' => $registrations,
            'recommendedCompetitions' => $recommendedCompetitions,
            'verifiedCount' => $verifiedCount,
            'actionNeededCount' => $actionNeededCount,
            'pendingVerifyCount' => $pendingVerifyCount,
            'upcomingSchedules' => $upcomingSchedules->take(4),
            'nearestSchedule' => $nearestSchedule,
            'announcements' => $announcements,
            'announcementCount' => $announcements->count(),
        ]);
    }

    /**
     * Halaman Jelajah Lomba (Katalog & Filter Sesuai Jenjang).
     */
    public function explore(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $search = trim((string) $request->query('q', ''));
        $category = (string) $request->query('kategori', 'all');
        $status = (string) $request->query('status', 'all');
        $matchEducation = $request->boolean('sesuai_jenjang');

        $query = Competition::withCount('registrations')
            ->orderByRaw("CASE WHEN status = 'buka' THEN 0 WHEN status = 'segera' THEN 1 ELSE 2 END")
            ->orderBy('registration_end');

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('short_title', 'like', '%'.$search.'%')
                    ->orWhere('organizer', 'like', '%'.$search.'%')
                    ->orWhere('category_label', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        if ($category !== '' && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($status !== '' && $status !== 'all') {
            $query->where('status', $status);
        }

        $competitions = $query->get();

        if ($matchEducation && ! empty($user->education_level)) {
            $competitions = $competitions
                ->filter(fn (Competition $competition): bool => $competition->supportsEducationLevel($user->education_level))
                ->values();
        }

        $userRegistrations = $user->competitionRegistrations()
            ->get()
            ->keyBy('competition_id');

        return view('dashboard.peserta.explore', [
            'user' => $user,
            'competitions' => $competitions,
            'userRegistrations' => $userRegistrations,
            'search' => $search,
            'category' => $category,
            'status' => $status,
            'matchEducation' => $matchEducation,
        ]);
    }

    /**
     * Halaman Detail Lomba Menyeluruh (Sesuai BPMN Peserta).
     */
    public function showCompetition(Competition $competition): View
    {
        /** @var User $user */
        $user = Auth::user();

        $competition->loadCount('registrations');

        $existingRegistration = $user->competitionRegistrations()
            ->where('competition_id', $competition->id)
            ->first();

        $competitionAnnouncements = $competition->announcements()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $registeredCount = $competition->registrations_count;
        $remainingQuota = max(0, $competition->quota - $registeredCount);
        $quotaPercentage = $competition->quota > 0
            ? min(100, (int) round(($registeredCount / $competition->quota) * 100))
            : 0;

        return view('dashboard.peserta.competition-detail', [
            'user' => $user,
            'competition' => $competition,
            'existingRegistration' => $existingRegistration,
            'competitionAnnouncements' => $competitionAnnouncements,
            'remainingQuota' => $remainingQuota,
            'quotaPercentage' => $quotaPercentage,
            'isEligibleLevel' => $competition->supportsEducationLevel($user->education_level),
        ]);
    }

    /**
     * Proses pendaftaran peserta ke sebuah lomba.
     */
    public function registerCompetition(Request $request, Competition $competition): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $competition->isRegistrationOpen()) {
            return redirect()
                ->route('peserta.competitions.show', $competition)
                ->with('error', 'Maaf, pendaftaran untuk kompetisi ini sedang tidak dibuka.');
        }

        $alreadyRegistered = $user->competitionRegistrations()
            ->where('competition_id', $competition->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()
                ->route('peserta.registrations.index')
                ->with('info', 'Anda sudah terdaftar pada kompetisi '.$competition->short_title.'.');
        }

        $currentCount = $competition->registrations()->count();
        if ($currentCount >= $competition->quota) {
            return redirect()
                ->route('peserta.competitions.show', $competition)
                ->with('error', 'Mohon maaf, kuota peserta untuk '.$competition->short_title.' sudah penuh.');
        }

        $rules = [
            'branch' => ['nullable', 'string', 'max:120'],
            'agree_rules' => ['accepted'],
        ];

        $branches = $competition->branches ?? [];
        if (! empty($branches)) {
            $rules['branch'] = ['required', 'string', 'in:'.implode(',', $branches)];
        }

        if ($competition->isTeamCompetition()) {
            $rules['team_name'] = ['required', 'string', 'max:120'];
            $rules['member_names'] = ['nullable', 'array', 'max:'.max(0, $competition->max_team_members - 1)];
            $rules['member_names.*'] = ['nullable', 'string', 'max:120'];
            $rules['member_nisns'] = ['nullable', 'array'];
            $rules['member_nisns.*'] = ['nullable', 'string', 'max:25'];
        }

        $messages = [
            'branch.required' => 'Silakan pilih cabang atau bidang lomba yang ingin diikuti.',
            'branch.in' => 'Bidang lomba yang dipilih tidak valid.',
            'team_name.required' => 'Nama tim wajib diisi untuk lomba kategori tim.',
            'agree_rules.accepted' => 'Anda harus menyetujui ketentuan dan tata tertib lomba.',
        ];

        $validated = $request->validate($rules, $messages);

        $teamMembers = null;
        if ($competition->isTeamCompetition()) {
            $names = $validated['member_names'] ?? [];
            $nisns = $validated['member_nisns'] ?? [];
            $members = [];

            foreach ($names as $index => $memberName) {
                $cleanName = trim((string) $memberName);
                if ($cleanName !== '') {
                    $members[] = [
                        'name' => $cleanName,
                        'nisn' => trim((string) ($nisns[$index] ?? '')),
                    ];
                }
            }

            $teamMembers = $members;
        }

        $prefix = strtoupper(Str::slug(Str::words($competition->short_title, 1, ''), ''));
        $sequence = str_pad((string) ($competition->registrations()->count() + 1), 4, '0', STR_PAD_LEFT);
        $registrationNumber = 'DEL-'.$prefix.'-'.date('Y').'-'.$sequence.'-'.strtoupper(Str::random(3));

        $initialStatus = $competition->registration_fee === 0
            ? 'menunggu_verifikasi'
            : 'menunggu_pembayaran';

        $adminNote = $competition->registration_fee === 0
            ? 'Pendaftaran gratis diterima. Silakan lengkapi kartu pelajar untuk mempercepat verifikasi panitia.'
            : 'Pendaftaran awal berhasil dicatat. Silakan unggah bukti pembayaran ('.$competition->formattedFee().') dan berkas persyaratan sebelum '.$competition->registration_end?->translatedFormat('d M Y').'.';

        CompetitionRegistration::create([
            'user_id' => $user->id,
            'competition_id' => $competition->id,
            'registration_number' => $registrationNumber,
            'branch' => $validated['branch'] ?? null,
            'team_name' => $competition->isTeamCompetition() ? trim((string) $validated['team_name']) : null,
            'team_members' => $teamMembers,
            'status' => $initialStatus,
            'admin_notes' => $adminNote,
        ]);

        return redirect()
            ->route('peserta.registrations.index')
            ->with('success', 'Berhasil mendaftar '.$competition->short_title.'! Nomor registrasi Anda: '.$registrationNumber.'. Silakan lanjutkan unggah berkas dan bukti pembayaran.');
    }

    /**
     * Halaman Lomba Saya (Tracking Progres & Upload Berkas).
     */
    public function myCompetitions(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $registrations = $user->competitionRegistrations()
            ->with('competition')
            ->latest()
            ->get();

        return view('dashboard.peserta.my-competitions', [
            'user' => $user,
            'registrations' => $registrations,
        ]);
    }

    /**
     * Proses unggah bukti pembayaran dan berkas persyaratan lomba.
     */
    public function uploadDocuments(Request $request, CompetitionRegistration $registration): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($registration->user_id === $user->id, 403);

        if ($registration->isVerified()) {
            return redirect()
                ->route('peserta.registrations.index')
                ->with('info', 'Pendaftaran ini sudah terverifikasi oleh panitia.');
        }

        $validated = $request->validate([
            'payment_proof' => ['required_without_all:student_card,recommendation_letter', 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'student_card' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'recommendation_letter' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ], [
            'payment_proof.required_without_all' => 'Silakan pilih minimal satu berkas (bukti pembayaran atau dokumen persyaratan) untuk diunggah.',
            'payment_proof.mimes' => 'Bukti pembayaran harus berformat JPG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran berkas maksimal 4 MB.',
            'student_card.mimes' => 'Kartu pelajar harus berformat JPG, PNG, atau PDF.',
            'recommendation_letter.mimes' => 'Surat rekomendasi harus berformat JPG, PNG, atau PDF.',
        ]);

        $folder = 'registrations/user-'.$user->id;
        $updates = [];

        if ($request->hasFile('payment_proof')) {
            if (! empty($registration->payment_proof_path)) {
                Storage::disk('public')->delete($registration->payment_proof_path);
            }
            $updates['payment_proof_path'] = $request->file('payment_proof')->store($folder, 'public');
            $updates['payment_submitted_at'] = now();
        }

        if ($request->hasFile('student_card')) {
            if (! empty($registration->student_card_path)) {
                Storage::disk('public')->delete($registration->student_card_path);
            }
            $updates['student_card_path'] = $request->file('student_card')->store($folder, 'public');
        }

        if ($request->hasFile('recommendation_letter')) {
            if (! empty($registration->recommendation_letter_path)) {
                Storage::disk('public')->delete($registration->recommendation_letter_path);
            }
            $updates['recommendation_letter_path'] = $request->file('recommendation_letter')->store($folder, 'public');
        }

        if (! empty($updates)) {
            $updates['status'] = 'menunggu_verifikasi';
            $updates['admin_notes'] = 'Berkas dan bukti pembayaran telah diterima sistem. Menunggu verifikasi panitia Del Olympic (estimasi 1×24 jam).';
            $registration->update($updates);
        }

        return redirect()
            ->route('peserta.registrations.index')
            ->with('success', 'Berkas untuk '.$registration->competition->short_title.' berhasil diunggah! Status pendaftaran kini Menunggu Verifikasi Panitia.');
    }

    /**
     * Halaman Kartu Peserta Ujian (siap cetak / simpan PDF).
     */
    public function participantCard(CompetitionRegistration $registration): View
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($registration->user_id === $user->id, 403);
        abort_unless($registration->isVerified(), 403, 'Kartu peserta hanya tersedia setelah pendaftaran diverifikasi panitia.');

        $registration->load('competition');

        return view('dashboard.peserta.participant-card', [
            'user' => $user,
            'registration' => $registration,
        ]);
    }

    /**
     * Halaman Jadwal & Pengumuman Personal.
     */
    public function schedule(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $registrations = $user->competitionRegistrations()
            ->with('competition')
            ->get();

        $registeredIds = $registrations->pluck('competition_id')->all();
        $allCompetitions = Competition::orderBy('event_date')->get();

        $schedules = $this->buildUpcomingSchedules($registrations, $allCompetitions);

        $announcements = Announcement::with('competition')
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->get();

        return view('dashboard.peserta.schedule', [
            'user' => $user,
            'registrations' => $registrations,
            'registeredIds' => $registeredIds,
            'schedules' => $schedules,
            'announcements' => $announcements,
        ]);
    }

    /**
     * Halaman Hasil Lomba & E-Sertifikat.
     */
    public function certificates(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $registrations = $user->competitionRegistrations()
            ->with('competition')
            ->latest()
            ->get();

        $verifiedRegistrations = $registrations
            ->filter(fn (CompetitionRegistration $reg): bool => $reg->isVerified())
            ->values();

        return view('dashboard.peserta.certificates', [
            'user' => $user,
            'registrations' => $registrations,
            'verifiedRegistrations' => $verifiedRegistrations,
        ]);
    }

    /**
     * Halaman Profil Saya.
     */
    public function profile(): View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('dashboard.peserta.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Perbarui biodata peserta dan kata sandi (opsional).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'nisn' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'in:Laki-laki,Perempuan'],
            'school_name' => ['required', 'string', 'max:255'],
            'education_level' => ['required', 'string', 'in:SD,SMP,SMA,SMK,Lainnya'],
            'grade' => ['nullable', 'string', 'max:30'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp/telepon wajib diisi.',
            'school_name.required' => 'Asal sekolah wajib diisi.',
            'education_level.required' => 'Jenjang pendidikan wajib dipilih.',
            'new_password.min' => 'Kata sandi baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $updateData = [
            'name' => trim($validated['name']),
            'phone' => trim($validated['phone']),
            'nisn' => ! empty($validated['nisn']) ? trim($validated['nisn']) : null,
            'gender' => $validated['gender'] ?? null,
            'school_name' => trim($validated['school_name']),
            'education_level' => $validated['education_level'],
            'grade' => ! empty($validated['grade']) ? trim($validated['grade']) : null,
            'city' => ! empty($validated['city']) ? trim($validated['city']) : null,
            'province' => ! empty($validated['province']) ? trim($validated['province']) : null,
        ];

        if (! empty($validated['new_password'])) {
            $updateData['password'] = Hash::make($validated['new_password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('peserta.profile')
            ->with('success', 'Biodata profil peserta berhasil diperbarui!');
    }

    /**
     * Menyusun daftar jadwal mendatang dari lomba yang diikuti (atau lomba terbuka bila belum ada).
     *
     * @param  Collection<int, CompetitionRegistration>  $registrations
     * @param  Collection<int, Competition>  $allCompetitions
     * @return Collection<int, array<string, mixed>>
     */
    private function buildUpcomingSchedules(Collection $registrations, Collection $allCompetitions): Collection
    {
        $sourceCompetitions = $registrations->isNotEmpty()
            ? $registrations->map(fn (CompetitionRegistration $reg): ?Competition => $reg->competition)->filter()
            : $allCompetitions;

        $registrationMap = $registrations->keyBy('competition_id');
        $today = Carbon::today();
        $events = collect();

        foreach ($sourceCompetitions as $competition) {
            /** @var Competition $competition */
            $reg = $registrationMap->get($competition->id);
            $isJoined = $reg !== null;

            if ($competition->registration_end !== null && (! $isJoined || ! $reg->isVerified())) {
                $events->push([
                    'date' => $competition->registration_end,
                    'day_label' => $competition->registration_end->format('d'),
                    'month_label' => $competition->registration_end->translatedFormat('M'),
                    'full_date' => $competition->registration_end->translatedFormat('d M Y'),
                    'title' => $isJoined ? 'Batas Unggah Berkas & Bayar '.$competition->short_title : 'Batas Pendaftaran '.$competition->short_title,
                    'competition_title' => $competition->short_title,
                    'competition_slug' => $competition->slug,
                    'type' => 'deadline',
                    'is_joined' => $isJoined,
                    'days_left' => (int) $today->diffInDays($competition->registration_end, false),
                ]);
            }

            if ($competition->technical_meeting_date !== null) {
                $events->push([
                    'date' => $competition->technical_meeting_date,
                    'day_label' => $competition->technical_meeting_date->format('d'),
                    'month_label' => $competition->technical_meeting_date->translatedFormat('M'),
                    'full_date' => $competition->technical_meeting_date->translatedFormat('d M Y'),
                    'title' => 'Technical Meeting '.$competition->short_title,
                    'competition_title' => $competition->short_title,
                    'competition_slug' => $competition->slug,
                    'type' => 'tm',
                    'is_joined' => $isJoined,
                    'days_left' => (int) $today->diffInDays($competition->technical_meeting_date, false),
                ]);
            }

            if ($competition->event_date !== null) {
                $events->push([
                    'date' => $competition->event_date,
                    'day_label' => $competition->event_date->format('d'),
                    'month_label' => $competition->event_date->translatedFormat('M'),
                    'full_date' => $competition->event_date->translatedFormat('d M Y'),
                    'title' => 'Pelaksanaan Babak Penyisihan '.$competition->short_title,
                    'competition_title' => $competition->short_title,
                    'competition_slug' => $competition->slug,
                    'type' => 'exam',
                    'is_joined' => $isJoined,
                    'days_left' => (int) $today->diffInDays($competition->event_date, false),
                ]);
            }

            if ($competition->final_date !== null) {
                $events->push([
                    'date' => $competition->final_date,
                    'day_label' => $competition->final_date->format('d'),
                    'month_label' => $competition->final_date->translatedFormat('M'),
                    'full_date' => $competition->final_date->translatedFormat('d M Y'),
                    'title' => 'Babak Final & Awarding '.$competition->short_title,
                    'competition_title' => $competition->short_title,
                    'competition_slug' => $competition->slug,
                    'type' => 'final',
                    'is_joined' => $isJoined,
                    'days_left' => (int) $today->diffInDays($competition->final_date, false),
                ]);
            }
        }

        return $events
            ->sortBy(fn (array $item): int => $item['date']->timestamp)
            ->values();
    }
}
