<?php

namespace App\Helpers;

use App\Models\Video;

class DefaultVideos
{
    /**
     * Crear un vídeo per defecte.
     *
     * @return Video
     */
    public function crearVideoPerDefecte(): Video
    {
        return Video::create([
            'title' => 'Vídeo per defecte',
            'url' => 'https://example.com/default-video',
            'description' => 'Aquest és un vídeo per defecte.',
            'published_at' => now(),
        ]);
    }

    /**
     * Crear un vídeo personalitzat.
     *
     * @param string $title
     * @param string $url
     * @param string $description
     * @param \DateTimeInterface|null $publishedAt
     * @return Video
     */
    public function crearVideoPersonalitzat(
        string $title,
        string $url,
        string $description,
        ?\DateTimeInterface $publishedAt = null
    ): Video {
        return Video::create([
            'title' => $title,
            'url' => $url,
            'description' => $description,
            'published_at' => $publishedAt ?? now(),
        ]);
    }
}
