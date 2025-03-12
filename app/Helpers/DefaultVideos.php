<?php

namespace App\Helpers;

use App\Models\Video;

class DefaultVideos
{
    /**
     * Crea un vídeo per defecte.
     *
     * @return Video
     */
    public function crearVideoPerDefecte(): Video
    {
        return Video::create([
            'title' => 'Vídeo per defecte',
            'description' => 'Aquest és un vídeo per defecte.',
            'url' => 'https://example.com/default-video',
            'published_at' => now(),
        ]);
    }

    /**
     * Crea tres vídeos per defecte.
     *
     * @return void
     */
    public static function crearVideosPerDefecte(): void
    {
        $videos = [
            [
                'title' => 'Vídeo 1 per defecte',
                'description' => 'Descripció del vídeo 1',
                'url' => 'https://example.com/default-video-1',
                'published_at' => now(),
            ],
            [
                'title' => 'Vídeo 2 per defecte',
                'description' => 'Descripció del vídeo 2',
                'url' => 'https://example.com/default-video-2',
                'published_at' => now(),
            ],
            [
                'title' => 'Vídeo 3 per defecte',
                'description' => 'Descripció del vídeo 3',
                'url' => 'https://example.com/default-video-3',
                'published_at' => now(),
            ],
        ];

        foreach ($videos as $video) {
            Video::firstOrCreate(['title' => $video['title']], $video);
        }
    }
}
