<?php

namespace Tests\Feature;

use App\Models\Competition;
use App\Models\CompetitionRegistration;
use App\Models\User;
use Database\Seeders\CompetitionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PesertaDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createPeserta(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Budi Santoso',
            'role' => 'peserta',
            'status_akun' => 'aktif',
            'phone' => '081234567890',
            'nisn' => '0071234567',
            'gender' => 'Laki-laki',
            'school_name' => 'SMA N 1 Laguboti',
            'education_level' => 'SMA',
            'grade' => 'Kelas XI',
            'city' => 'Kabupaten Toba',
            'province' => 'Sumatera Utara',
        ], $overrides));
    }

    public function test_guest_is_redirected_from_peserta_dashboard(): void
    {
        $response = $this->get(route('peserta.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_peserta_can_view_dashboard_overview_and_explore_pages(): void
    {
        $this->seed(CompetitionSeeder::class);
        $peserta = $this->createPeserta();

        $this->actingAs($peserta)
            ->get(route('peserta.dashboard'))
            ->assertOk()
            ->assertSee('Selamat Datang, Budi Santoso!')
            ->assertSee('Lomba Saya (Status Pendaftaran)')
            ->assertSee('Rekomendasi Lomba');

        $this->actingAs($peserta)
            ->get(route('peserta.competitions.index', ['sesuai_jenjang' => 1]))
            ->assertOk()
            ->assertSee('DMSC 2026')
            ->assertSee('POSI x Del 2026')
            ->assertSee('Del Tech 2026');
    }

    public function test_peserta_can_view_full_competition_detail_page(): void
    {
        $this->seed(CompetitionSeeder::class);
        $peserta = $this->createPeserta();
        $dmsc = Competition::where('slug', 'dmsc-2026')->firstOrFail();

        $this->actingAs($peserta)
            ->get(route('peserta.competitions.show', $dmsc))
            ->assertOk()
            ->assertSee('DMSC 2026')
            ->assertSee('Timeline Tahapan Lomba')
            ->assertSee('Silabus & Kisi-Kisi Materi', false)
            ->assertSee('Syarat & Berkas Wajib', false)
            ->assertSee('Daftar Lomba Ini Sekarang');
    }

    public function test_peserta_can_register_for_individual_and_team_competitions(): void
    {
        $this->seed(CompetitionSeeder::class);
        $peserta = $this->createPeserta();
        $posi = Competition::where('slug', 'posi-del-2026')->firstOrFail();
        $deltech = Competition::where('slug', 'del-tech-2026')->firstOrFail();

        // Daftar lomba individu (POSI)
        $this->actingAs($peserta)
            ->post(route('peserta.competitions.register', $posi), [
                'branch' => 'Matematika',
                'agree_rules' => '1',
            ])
            ->assertRedirect(route('peserta.registrations.index'));

        $this->assertDatabaseHas('competition_registrations', [
            'user_id' => $peserta->id,
            'competition_id' => $posi->id,
            'branch' => 'Matematika',
            'status' => 'menunggu_pembayaran',
        ]);

        // Daftar lomba tim (Del Tech)
        $this->actingAs($peserta)
            ->post(route('peserta.competitions.register', $deltech), [
                'branch' => 'Web & UI/UX Design Challenge',
                'team_name' => 'Tim Danau Toba',
                'member_names' => ['Siti Rahma', 'Andi Pratama'],
                'member_nisns' => ['0079876543', '0074561239'],
                'agree_rules' => '1',
            ])
            ->assertRedirect(route('peserta.registrations.index'));

        $teamReg = CompetitionRegistration::where('user_id', $peserta->id)
            ->where('competition_id', $deltech->id)
            ->firstOrFail();

        $this->assertSame('Tim Danau Toba', $teamReg->team_name);
        $this->assertCount(2, $teamReg->team_members);
    }

    public function test_peserta_can_upload_payment_proof_and_documents(): void
    {
        Storage::fake('public');
        $this->seed(CompetitionSeeder::class);
        $peserta = $this->createPeserta();
        $dmsc = Competition::where('slug', 'dmsc-2026')->firstOrFail();

        $registration = CompetitionRegistration::create([
            'user_id' => $peserta->id,
            'competition_id' => $dmsc->id,
            'registration_number' => 'DEL-DMSC-2026-9999',
            'branch' => 'Matematika',
            'status' => 'menunggu_pembayaran',
        ]);

        $this->actingAs($peserta)
            ->post(route('peserta.registrations.upload', $registration), [
                'payment_proof' => UploadedFile::fake()->create('bukti-bayar.pdf', 120, 'application/pdf'),
                'student_card' => UploadedFile::fake()->image('kartu-pelajar.jpg'),
            ])
            ->assertRedirect(route('peserta.registrations.index'));

        $registration->refresh();

        $this->assertSame('menunggu_verifikasi', $registration->status);
        $this->assertNotNull($registration->payment_proof_path);
        $this->assertNotNull($registration->student_card_path);
        Storage::disk('public')->assertExists($registration->payment_proof_path);
        Storage::disk('public')->assertExists($registration->student_card_path);
    }

    public function test_participant_card_requires_verified_registration_and_owner(): void
    {
        $this->seed(CompetitionSeeder::class);
        $peserta = $this->createPeserta();
        $otherPeserta = $this->createPeserta(['email' => 'lain@example.com']);
        $dmsc = Competition::where('slug', 'dmsc-2026')->firstOrFail();

        $registration = CompetitionRegistration::create([
            'user_id' => $peserta->id,
            'competition_id' => $dmsc->id,
            'registration_number' => 'DEL-DMSC-2026-8888',
            'branch' => 'Matematika',
            'status' => 'menunggu_pembayaran',
        ]);

        // Belum terverifikasi -> 403
        $this->actingAs($peserta)
            ->get(route('peserta.registrations.card', $registration))
            ->assertForbidden();

        // Terverifikasi -> 200 untuk pemilik, 403 untuk user lain
        $registration->update(['status' => 'terverifikasi', 'verified_at' => now()]);

        $this->actingAs($peserta)
            ->get(route('peserta.registrations.card', $registration))
            ->assertOk()
            ->assertSee('DEL-DMSC-2026-8888')
            ->assertSee('TERVERIFIKASI');

        $this->actingAs($otherPeserta)
            ->get(route('peserta.registrations.card', $registration))
            ->assertForbidden();
    }

    public function test_peserta_can_view_schedule_certificates_and_update_profile(): void
    {
        $this->seed(CompetitionSeeder::class);
        $peserta = $this->createPeserta();

        $this->actingAs($peserta)
            ->get(route('peserta.schedule'))
            ->assertOk()
            ->assertSee('Jadwal & Pengumuman', false);

        $this->actingAs($peserta)
            ->get(route('peserta.certificates'))
            ->assertOk()
            ->assertSee('Sertifikat & Hasil Lomba', false);

        $this->actingAs($peserta)
            ->put(route('peserta.profile.update'), [
                'name' => 'Budi Santoso Updated',
                'phone' => '081299998888',
                'nisn' => '0071234568',
                'gender' => 'Laki-laki',
                'school_name' => 'SMA N 2 Balige',
                'education_level' => 'SMA',
                'grade' => 'Kelas XII',
                'city' => 'Kabupaten Toba',
                'province' => 'Sumatera Utara',
            ])
            ->assertRedirect(route('peserta.profile'));

        $this->assertDatabaseHas('users', [
            'id' => $peserta->id,
            'name' => 'Budi Santoso Updated',
            'school_name' => 'SMA N 2 Balige',
            'grade' => 'Kelas XII',
        ]);
    }
}
