<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'status_akun',
    'phone',
    'nisn',
    'gender',
    'school_name',
    'education_level',
    'grade',
    'province',
    'city',
    'institution_name',
    'institution_type',
    'position',
    'institution_address',
    'institution_website',
    'institution_phone',
    'document_link',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPenyelenggara(): bool
    {
        return $this->role === 'penyelenggara';
    }

    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }

    /**
     * Daftar registrasi lomba yang diikuti peserta.
     *
     * @return HasMany<CompetitionRegistration, $this>
     */
    public function competitionRegistrations(): HasMany
    {
        return $this->hasMany(CompetitionRegistration::class);
    }

    /**
     * Cek apakah biodata inti peserta sudah lengkap untuk kartu peserta & sertifikat.
     */
    public function isParticipantProfileComplete(): bool
    {
        return ! empty($this->name)
            && ! empty($this->phone)
            && ! empty($this->nisn)
            && ! empty($this->school_name)
            && ! empty($this->education_level)
            && ! empty($this->grade);
    }
}