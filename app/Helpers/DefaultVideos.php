<?php

namespace App\Helpers;

use App\Models\Video;
use App\Models\User;

class DefaultVideos
{
    /**
     * Crea un vídeo per defecte per a un usuari concret.
     *
     * @param User $user
     * @return Video
     */
    public function crearVideoPerDefecte(User $user): Video
    {
        return Video::create([
            'title' => 'Vídeo per defecte',
            'description' => 'Aquest és un vídeo per defecte.',
            'url' => 'https://www.youtube.com/watch?v=bvf2GPDtPSg',
            'published_at' => now(),
            'user_id' => $user->id,
        ]);
    }

    /**
     * Crea tres vídeos per defecte associats al super-admin (user_id = 1).
     *
     * @return void
     */
    public static function crearVideosPerDefecte(): void
    {
        $defaultUser = \App\Models\User::find(1); // o busca pel correu si vols assegurar-te
        if (!$defaultUser) return;

        $videos = [
            [
                'title' => 'Vídeo 1 per defecte',
                'description' => 'Descripció del vídeo 1',
                'url' => 'https://www.youtube.com/watch?v=odOjFTEcGA8',
                'published_at' => now(),
                'user_id' => $defaultUser->id,
            ],
            [
                'title' => 'Vídeo 2 per defecte',
                'description' => 'Descripció del vídeo 2',
                'url' => 'https://www.youtube.com/watch?v=x200msN-QT8',
                'published_at' => now(),
                'user_id' => $defaultUser->id,
            ],
            [
                'title' => 'Vídeo 3 per defecte',
                'description' => 'Descripció del vídeo 3',
                'url' => 'https://www.youtube.com/watch?v=4e40AZ0yq2U&t=199s',
                'published_at' => now(),
                'user_id' => $defaultUser->id,
            ],
        ];

        foreach ($videos as $video) {
            Video::firstOrCreate(['title' => $video['title']], $video);
        }
    }
}
