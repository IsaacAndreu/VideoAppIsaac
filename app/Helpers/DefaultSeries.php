<?php

namespace App\Helpers;

use App\Models\Serie;

class DefaultSeries
{
    /**
     * Crear 3 sèries per defecte.
     *
     * @return void
     */
    public static function create_series(): void
    {
        Serie::create([
            'title' => 'Sèrie 1',
            'description' => 'Descripció de la primera sèrie.',
            'image' => null,
            'user_name' => 'Super Admin',
            'user_photo_url' => null,
            'published_at' => now(),
        ]);

        Serie::create([
            'title' => 'Sèrie 2',
            'description' => 'Descripció de la segona sèrie.',
            'image' => null,
            'user_name' => 'Super Admin',
            'user_photo_url' => null,
            'published_at' => now(),
        ]);

        Serie::create([
            'title' => 'Sèrie 3',
            'description' => 'Descripció de la tercera sèrie.',
            'image' => null,
            'user_name' => 'Super Admin',
            'user_photo_url' => null,
            'published_at' => now(),
        ]);
    }
}
