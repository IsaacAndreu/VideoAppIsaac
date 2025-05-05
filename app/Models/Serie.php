<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_name',
        'user_photo_url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relació amb el model Video (1:N).
     *
     * Una sèrie té molts vídeos.
     *
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * (Opcional) Relació amb usuaris que han testejat (per si es demana més tard).
     *
     * @return BelongsTo
     */
    public function testedby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_name', 'name');
    }

    /**
     * Data de creació en format "13 de gener de 2025".
     *
     * @return string|null
     */
    public function getFormattedCreatedAtAttribute(): ?string
    {
        if (!$this->created_at) {
            return null;
        }

        return str_replace(' de de ', ' de ', $this->created_at->translatedFormat('d \d\e F \d\e Y'));
    }

    /**
     * Data de creació en format "fa 2 hores".
     *
     * @return string|null
     */
    public function getFormattedForHumansCreatedAtAttribute(): ?string
    {
        return $this->created_at
            ? $this->created_at->diffForHumans()
            : null;
    }

    /**
     * Timestamp Unix de la creació.
     *
     * @return int|null
     */
    public function getCreatedAtTimestampAttribute(): ?int
    {
        return $this->created_at?->timestamp;
    }
}
