<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Competition;
use App\Models\CompetitionRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Seed kompetisi resmi Del Olympic, pengumuman, dan contoh pendaftaran demo.
     */
    public function run(): void
    {
        $dmsc = Competition::updateOrCreate(
            ['slug' => 'dmsc-2026'],
            [
                'title' => 'Del Mathematics and Science Competition (DMSC)',
                'short_title' => 'DMSC 2026',
                'subtitle' => 'Olimpiade Tahunan',
                'organizer' => 'Institut Teknologi Del (IT Del)',
                'category' => 'sains',
                'category_label' => 'Matematika & Sains',
                'participation_type' => 'individu',
                'min_team_members' => 1,
                'max_team_members' => 1,
                'education_levels' => ['SD', 'SMP', 'SMA', 'SMK'],
                'education_label' => 'SD, SMP, SMA / SMK Sederajat',
                'status' => 'buka',
                'registration_fee' => 75000,
                'fee_unit' => 'Peserta',
                'quota' => 500,
                'registration_start' => '2026-10-10',
                'registration_end' => '2026-12-15',
                'technical_meeting_date' => '2026-12-18',
                'event_date' => '2026-12-20',
                'final_date' => '2027-01-10',
                'total_prize_summary' => 'Rp 25.000.000 + Beasiswa',
                'description' => 'DMSC merupakan agenda tahunan prestisius yang diadakan oleh civitas akademika Institut Teknologi Del untuk memupuk daya nalar kritis, ketajaman logika matematika, serta pemahaman sains mendalam bagi pelajar di seluruh Indonesia.',
                'prizes' => [
                    'Juara 1: Trophy + Piagam + Uang Pembinaan Rp 10.000.000 + Beasiswa Kuliah IT Del',
                    'Juara 2: Trophy + Piagam + Uang Pembinaan Rp 7.500.000',
                    'Juara 3: Trophy + Piagam + Uang Pembinaan Rp 5.000.000',
                    'Seluruh Peserta: E-Sertifikat Nasional ber-barcode verifikasi resmi',
                ],
                'syllabus' => [
                    'Matematika Diskrit & Kombinatorika',
                    'Kalkulus Dasar & Aljabar',
                    'Logika & Geometri Analitik',
                    'Fisika Mekanika & Kinematika',
                    'Termodinamika & Gelombang Sains',
                ],
                'requirements' => [
                    'Pelajar aktif jenjang SD, SMP, SMA, atau SMK sederajat di seluruh Indonesia',
                    'Mengisi biodata lengkap termasuk NISN & asal sekolah pada Profil Akun',
                    'Mengunggah scan Kartu Pelajar atau Surat Rekomendasi Sekolah',
                    'Mengunggah bukti pembayaran biaya registrasi sebesar Rp 75.000',
                ],
                'timeline' => [
                    [
                        'step' => 1,
                        'title' => 'Pendaftaran & Verifikasi',
                        'date_label' => '10 Okt – 15 Des 2026',
                        'description' => 'Registrasi akun, pemilihan bidang lomba, unggah berkas, dan konfirmasi pembayaran.',
                    ],
                    [
                        'step' => 2,
                        'title' => 'Technical Meeting',
                        'date_label' => '18 Des 2026',
                        'description' => 'Penjelasan tata tertib ujian CBT dan simulasi sistem secara daring via Zoom.',
                    ],
                    [
                        'step' => 3,
                        'title' => 'Babak Penyisihan (CBT)',
                        'date_label' => '20 Des 2026',
                        'description' => 'Ujian serentak berbasis Computer Based Test (CBT) secara daring.',
                    ],
                    [
                        'step' => 4,
                        'title' => 'Final & Awarding',
                        'date_label' => '10 Jan 2027',
                        'description' => 'Babak final terpusat secara hybrid di Kampus IT Del dan penganugerahan juara.',
                    ],
                ],
                'branches' => [
                    'Matematika',
                    'Fisika & Sains Terapan',
                    'IPA Terpadu',
                ],
                'theme_image' => 'images/dmsc-theme.svg',
                'accent_color' => 'blue',
                'icon_symbol' => 'Σ',
                'guidebook_url' => '#panduan-dmsc',
                'group_link' => 'https://chat.whatsapp.com/delolympic-dmsc-2026',
                'contact_person' => 'Panitia DMSC — +62 812-3456-7890 (WA)',
                'exam_link' => 'https://cbt.delolympic.id/dmsc-2026',
            ]
        );

        $posi = Competition::updateOrCreate(
            ['slug' => 'posi-del-2026'],
            [
                'title' => 'Pusat Olimpiade Indonesia (POSI x Del)',
                'short_title' => 'POSI x Del 2026',
                'subtitle' => 'Kolaborasi Resmi',
                'organizer' => 'Pusat Olimpiade Indonesia (POSI) x Del Olympic',
                'category' => 'olimpiade',
                'category_label' => 'Olimpiade Nasional',
                'participation_type' => 'individu',
                'min_team_members' => 1,
                'max_team_members' => 1,
                'education_levels' => ['SMP', 'SMA', 'SMK'],
                'education_label' => 'SMP & SMA / SMK Sederajat',
                'status' => 'buka',
                'registration_fee' => 50000,
                'fee_unit' => 'Peserta',
                'quota' => 800,
                'registration_start' => '2026-11-01',
                'registration_end' => '2026-12-28',
                'technical_meeting_date' => '2027-01-06',
                'event_date' => '2027-01-10',
                'final_date' => '2027-01-15',
                'total_prize_summary' => 'Medali Fisik + Piagam Resmi',
                'description' => 'Ajang seleksi dan asah kompetensi sains berskala nasional hasil kemitraan strategis POSI bersama Del Olympic, dirancang sesuai standar silabus OSN Pusat Prestasi Nasional khusus pelajar SMP dan SMA.',
                'prizes' => [
                    'Medali Fisik (Emas, Perak, Perunggu) dikirim langsung ke alamat sekolah/peserta',
                    'Piagam Penghargaan resmi tingkat nasional berlisensi POSI',
                    'Akses pembahasan soal eksklusif dan pembinaan bimbingan juara',
                    'E-Sertifikat Nasional berlisensi resmi untuk seluruh peserta',
                ],
                'syllabus' => [
                    'Matematika Terpadu Standar OSN',
                    'IPA & Biologi Terpadu',
                    'Fisika Eksperimen & Teori',
                    'Astronomi & Kebumian',
                ],
                'requirements' => [
                    'Pelajar aktif jenjang SMP, SMA, atau SMK sederajat',
                    'Melampirkan Kartu Pelajar atau Surat Keterangan Siswa Aktif',
                    'Menyelesaikan pembayaran registrasi sebesar Rp 50.000 sebelum 28 Desember 2026',
                    'Memiliki perangkat komputer/laptop dan koneksi internet stabil untuk CBT',
                ],
                'timeline' => [
                    [
                        'step' => 1,
                        'title' => 'Pendaftaran Peserta',
                        'date_label' => '1 Nov – 28 Des 2026',
                        'description' => 'Pendaftaran daring dan unggah bukti pembayaran melalui dashboard peserta.',
                    ],
                    [
                        'step' => 2,
                        'title' => 'Simulasi & TM',
                        'date_label' => '6 Jan 2027',
                        'description' => 'Uji coba login ruang ujian CBT dan penjelasan mekanisme penilaian.',
                    ],
                    [
                        'step' => 3,
                        'title' => 'Pelaksanaan Olimpiade',
                        'date_label' => '10 Jan 2027',
                        'description' => 'Pelaksanaan ujian serentak nasional secara daring.',
                    ],
                    [
                        'step' => 4,
                        'title' => 'Pengumuman & Sertifikat',
                        'date_label' => '15 Jan 2027',
                        'description' => 'Rilis peringkat nasional, unduh E-Sertifikat, dan pengiriman medali fisik.',
                    ],
                ],
                'branches' => [
                    'Matematika',
                    'Biologi / IPA Terpadu',
                    'Fisika',
                    'Astronomi & Kebumian',
                ],
                'theme_image' => 'images/posi-theme.svg',
                'accent_color' => 'sky',
                'icon_symbol' => 'POSI',
                'guidebook_url' => '#panduan-posi',
                'group_link' => 'https://chat.whatsapp.com/delolympic-posi-2026',
                'contact_person' => 'Sekretariat POSI x Del — +62 813-7788-9900 (WA)',
                'exam_link' => 'https://cbt.delolympic.id/posi-2026',
            ]
        );

        $deltech = Competition::updateOrCreate(
            ['slug' => 'del-tech-2026'],
            [
                'title' => 'Del Technology Competition (Del Tech)',
                'short_title' => 'Del Tech 2026',
                'subtitle' => 'Inovasi Digital',
                'organizer' => 'Fakultas Informatika & Teknik Elektro IT Del',
                'category' => 'teknologi',
                'category_label' => 'Teknologi & IT',
                'participation_type' => 'tim',
                'min_team_members' => 1,
                'max_team_members' => 3,
                'education_levels' => ['SMA', 'SMK', 'Lainnya'],
                'education_label' => 'SMA/SMK & Mahasiswa (Tim 1–3 Orang)',
                'status' => 'buka',
                'registration_fee' => 100000,
                'fee_unit' => 'Tim',
                'quota' => 250,
                'registration_start' => '2026-10-15',
                'registration_end' => '2026-12-20',
                'technical_meeting_date' => '2026-12-27',
                'event_date' => '2027-01-05',
                'final_date' => '2027-01-15',
                'total_prize_summary' => 'Rp 35.000.000 + Golden Ticket',
                'description' => 'Del Tech menantang kreativitas generasi muda dalam rekayasa perangkat lunak, Competitive Programming, Web & UI/UX Design, serta Inovasi Solusi AI & IoT untuk menjawab permasalahan nyata di era Society 5.0.',
                'prizes' => [
                    'Juara 1: Piala Bergilir Rektor + Uang Pembinaan Rp 15.000.000 + Golden Ticket Magang',
                    'Juara 2: Trophy + Uang Pembinaan Rp 10.000.000',
                    'Juara 3: Trophy + Uang Pembinaan Rp 7.000.000',
                    'Best Innovation Award: Uang Pembinaan Rp 3.000.000 + E-Sertifikat',
                ],
                'syllabus' => [
                    'Algoritma & Competitive Programming (C++, Java, Python)',
                    'Web & Mobile UI/UX Design Challenge',
                    'Artificial Intelligence & Machine Learning Prototype',
                    'IoT & Smart Campus Solution Pitching',
                ],
                'requirements' => [
                    'Tim beranggotakan 1 hingga 3 orang dari jenjang SMA/SMK atau Mahasiswa aktif',
                    'Seluruh anggota tim wajib berasal dari sekolah/institusi yang sama',
                    'Mengunggah Kartu Pelajar/KTM ketua tim dan surat pengantar sekolah/kampus',
                    'Menyelesaikan pembayaran registrasi sebesar Rp 100.000 per tim',
                ],
                'timeline' => [
                    [
                        'step' => 1,
                        'title' => 'Pendaftaran Tim',
                        'date_label' => '15 Okt – 20 Des 2026',
                        'description' => 'Pendaftaran tim, pemilihan cabang teknologi, dan unggah bukti pembayaran.',
                    ],
                    [
                        'step' => 2,
                        'title' => 'Technical Meeting & Warm-Up',
                        'date_label' => '27 Des 2026',
                        'description' => 'Briefing juri, rubrik penilaian karya, dan sesi warm-up platform lomba.',
                    ],
                    [
                        'step' => 3,
                        'title' => 'Penyisihan & Submission',
                        'date_label' => '5 Jan 2027',
                        'description' => 'Pengumpulan proposal/prototipe atau babak penyisihan Competitive Programming.',
                    ],
                    [
                        'step' => 4,
                        'title' => 'Grand Final & Pitching',
                        'date_label' => '15 Jan 2027',
                        'description' => 'Presentasi finalis di hadapan dewan juri IT Del dan malam penganugerahan.',
                    ],
                ],
                'branches' => [
                    'Competitive Programming',
                    'Web & UI/UX Design Challenge',
                    'AI & IoT Solution Prototype',
                ],
                'theme_image' => 'images/deltech-theme.svg',
                'accent_color' => 'teal',
                'icon_symbol' => '</>',
                'guidebook_url' => '#panduan-deltech',
                'group_link' => 'https://chat.whatsapp.com/delolympic-deltech-2026',
                'contact_person' => 'Panitia Del Tech — +62 821-4455-6677 (WA)',
                'exam_link' => 'https://submission.delolympic.id/del-tech-2026',
            ]
        );

        // Pengumuman resmi untuk dashboard peserta
        $announcements = [
            [
                'competition_id' => $dmsc->id,
                'title' => 'Buku Panduan & Kisi-Kisi Resmi DMSC 2026 Sudah Tersedia',
                'body' => 'Peserta DMSC 2026 kini dapat mempelajari kisi-kisi materi terbaru dan tata tertib ujian Computer Based Test (CBT) langsung dari halaman Detail Lomba. Pastikan akun sudah terverifikasi sebelum 15 Desember 2026.',
                'category' => 'penting',
                'is_pinned' => true,
                'published_at' => now()->subHours(5),
            ],
            [
                'competition_id' => $deltech->id,
                'title' => 'Panduan Pengumpulan Proposal & Pembentukan Tim Del Tech 2026',
                'body' => 'Bagi peserta cabang Web UI/UX Design dan AI & IoT Solution Prototype, pastikan nama tim dan daftar anggota (1–3 orang) sudah dilengkapi pada menu Lomba Saya sebelum melakukan konfirmasi pembayaran.',
                'category' => 'jadwal',
                'is_pinned' => false,
                'published_at' => now()->subDay(),
            ],
            [
                'competition_id' => $posi->id,
                'title' => 'Pendaftaran Kolaborasi POSI x Del 2026 Resmi Dibuka',
                'body' => 'Olimpiade Sains Nasional Terpadu POSI x Del kini terbuka bagi seluruh pelajar SMP dan SMA/SMK sederajat dengan kuota 800 peserta. Segera amankan kursi Anda sebelum 28 Desember 2026.',
                'category' => 'info',
                'is_pinned' => false,
                'published_at' => now()->subDays(2),
            ],
            [
                'competition_id' => null,
                'title' => 'Pastikan Biodata & NISN Lengkap untuk Cetak Kartu Peserta dan E-Sertifikat',
                'body' => 'Nama lengkap, asal sekolah, jenjang pendidikan, dan NISN yang tersimpan di halaman Profil Saya akan dicetak secara otomatis pada Kartu Peserta Ujian dan E-Sertifikat Resmi Del Olympic.',
                'category' => 'penting',
                'is_pinned' => true,
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($announcements as $item) {
            Announcement::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }

        // Contoh pendaftaran realistis untuk akun demo peserta@delolympic.id
        $demoPeserta = User::where('email', 'peserta@delolympic.id')->first();
        if ($demoPeserta !== null) {
            CompetitionRegistration::firstOrCreate(
                [
                    'user_id' => $demoPeserta->id,
                    'competition_id' => $dmsc->id,
                ],
                [
                    'registration_number' => 'DEL-DMSC-2026-0104',
                    'branch' => 'Matematika',
                    'status' => 'terverifikasi',
                    'payment_submitted_at' => now()->subDays(4),
                    'verified_at' => now()->subDays(2),
                    'admin_notes' => 'Berkas dan bukti pembayaran telah diverifikasi oleh panitia. Kartu peserta siap diunduh.',
                    'result_status' => 'peserta',
                    'certificate_code' => 'CERT-DMSC-2026-0104',
                ]
            );

            CompetitionRegistration::firstOrCreate(
                [
                    'user_id' => $demoPeserta->id,
                    'competition_id' => $deltech->id,
                ],
                [
                    'registration_number' => 'DEL-TECH-2026-0042',
                    'branch' => 'Web & UI/UX Design Challenge',
                    'team_name' => 'Tim Toba Inovatif',
                    'team_members' => [
                        ['name' => 'Siti Rahma', 'nisn' => '0079876543'],
                        ['name' => 'Andi Pratama', 'nisn' => '0074561239'],
                    ],
                    'status' => 'menunggu_pembayaran',
                    'admin_notes' => 'Silakan unggah bukti transfer sebesar Rp 100.000 beserta kartu pelajar ketua tim sebelum 20 Desember 2026.',
                ]
            );
        }
    }
}
