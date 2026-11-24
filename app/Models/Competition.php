<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug',
    'title',
    'short_title',
    'subtitle',
    'organizer',
    'category',
    'category_label',
    'participation_type',
    'min_team_members',
    'max_team_members',
    'education_levels',
    'education_label',
    'status',
    'registration_fee',
    'fee_unit',
    'quota',
    'registration_start',
    'registration_end',
    'technical_meeting_date',
    'event_date',
    'final_date',
    'total_prize_summary',
    'description',
    'prizes',
    'syllabus',
    'requirements',
    'timeline',
    'branches',
    'theme_image',
    'accent_color',
    'icon_symbol',
    'guidebook_url',
    'group_link',
    'contact_person',
    'exam_link',
])]
class Competition extends Model
{
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'education_levels' => 'array',
            'prizes' => 'array',
            'syllabus' => 'array',
            'requirements' => 'array',
            'timeline' => 'array',
            'branches' => 'array',
            'registration_start' => 'date',
            'registration_end' => 'date',
            'technical_meeting_date' => 'date',
            'event_date' => 'date',
            'final_date' => 'date',
        ];
    }

    /**
     * Pendaftaran peserta untuk kompetisi ini.
     *
     * @return HasMany<CompetitionRegistration, $this>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(CompetitionRegistration::class);
    }

    /**
     * Pengumuman khusus kompetisi ini.
     *
     * @return HasMany<Announcement, $this>
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    /**
     * Cek apakah kompetisi cocok dengan jenjang pendidikan peserta.
     */
    public function supportsEducationLevel(?string $educationLevel): bool
    {
        if (empty($educationLevel)) {
            return true;
        }

        $levels = $this->education_levels ?? [];

        return in_array($educationLevel, $levels, true);
    }

    /**
     * Cek apakah lomba bertipe tim.
     */
    public function isTeamCompetition(): bool
    {
        return $this->participation_type === 'tim';
    }

    /**
     * Cek apakah pendaftaran sedang dibuka.
     */
    public function isRegistrationOpen(): bool
    {
        return $this->status === 'buka';
    }

    /**
     * Format biaya registrasi dalam Rupiah.
     */
    public function formattedFee(): string
    {
        if ($this->registration_fee === 0) {
            return 'Gratis';
        }

        return 'Rp '.number_format($this->registration_fee, 0, ',', '.').' / '.$this->fee_unit;
    }

    /**
     * Label status pendaftaran berbahasa Indonesia.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'buka' => 'Pendaftaran Dibuka',
            'segera' => 'Segera Dibuka',
            'tutup' => 'Ditutup',
            default => ucfirst($this->status),
        };
    }
}
