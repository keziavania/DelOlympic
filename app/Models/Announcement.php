<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'competition_id',
    'title',
    'body',
    'category',
    'is_pinned',
    'published_at',
])]
class Announcement extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Kompetisi terkait pengumuman (null jika pengumuman umum).
     *
     * @return BelongsTo<Competition, $this>
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Label kategori pengumuman.
     */
    public function categoryLabel(): string
    {
        return match ($this->category) {
            'penting' => 'Penting',
            'jadwal' => 'Jadwal',
            'hasil' => 'Hasil Lomba',
            default => 'Informasi',
        };
    }
}
