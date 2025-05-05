<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'published_at',
        'previous',
        'next',
        'series_id',
        'user_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relació: cada vídeo pertany a una sèrie.
     *
     * @return BelongsTo
     */
    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }

    /**
     * Retorna la data en format "13 de gener de 2025".
     *
     * @return string|null
     */
    public function getFormattedPublishedAtAttribute(): ?string
    {
        if (!$this->published_at) {
            return null;
        }

        return str_replace(' de de ', ' de ', $this->published_at->translatedFormat('d \d\e F \d\e Y'));
    }

    /**
     * Retorna la data en format "fa 2 hores".
     *
     * @return string|null
     */
    public function getFormattedForHumansPublishedAtAttribute(): ?string
    {
        return $this->published_at
            ? $this->published_at->diffForHumans()
            : null;
    }

    /**
     * Retorna el valor Unix timestamp de published_at.
     *
     * @return int|null
     */
    public function getPublishedAtTimestampAttribute(): ?int
    {
        return $this->published_at?->timestamp;
    }

    /**
     * Relació amb el model Test.
     *
     * @return HasMany<Test>
     */
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
