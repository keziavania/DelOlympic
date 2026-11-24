<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'competition_id',
    'registration_number',
    'branch',
    'team_name',
    'team_members',
    'status',
    'payment_proof_path',
    'student_card_path',
    'recommendation_letter_path',
    'payment_submitted_at',
    'verified_at',
    'admin_notes',
    'result_status',
    'score',
    'certificate_code',
])]
class CompetitionRegistration extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'team_members' => 'array',
            'payment_submitted_at' => 'datetime',
            'verified_at' => 'datetime',
            'score' => 'decimal:2',
        ];
    }

    /**
     * Peserta pemilik pendaftaran.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kompetisi yang didaftarkan.
     *
     * @return BelongsTo<Competition, $this>
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Label status verifikasi dalam bahasa Indonesia.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'revisi' => 'Perlu Revisi Berkas',
            'terverifikasi' => 'Terverifikasi',
            'ditolak' => 'Ditolak',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    /**
     * Kelas badge Tailwind untuk status pendaftaran.
     */
    public function statusBadgeClasses(): string
    {
        return match ($this->status) {
            'terverifikasi' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'menunggu_verifikasi' => 'bg-blue-100 text-blue-700 border-blue-200',
            'menunggu_pembayaran' => 'bg-amber-100 text-amber-800 border-amber-200',
            'revisi' => 'bg-orange-100 text-orange-800 border-orange-200',
            'ditolak' => 'bg-red-100 text-red-700 border-red-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }

    /**
     * Urutan langkah progres pendaftaran (1 sampai 4).
     */
    public function progressStep(): int
    {
        return match ($this->status) {
            'menunggu_pembayaran', 'revisi' => 2,
            'menunggu_verifikasi' => 3,
            'terverifikasi' => 4,
            default => 1,
        };
    }

    /**
     * Label hasil lomba jika tersedia.
     */
    public function resultLabel(): string
    {
        return match ($this->result_status) {
            'juara_1' => 'Juara 1 (Medali Emas)',
            'juara_2' => 'Juara 2 (Medali Perak)',
            'juara_3' => 'Juara 3 (Medali Perunggu)',
            'finalis' => 'Finalis Nasional',
            'peserta' => 'Peserta Terverifikasi',
            default => 'Belum Diumumkan',
        };
    }

    /**
     * Cek apakah pendaftaran sudah terverifikasi.
     */
    public function isVerified(): bool
    {
        return $this->status === 'terverifikasi';
    }
}
