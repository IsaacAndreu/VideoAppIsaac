<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear una sèrie
        $seriesId = DB::table('series')->insertGetId([
            'title' => 'Introducció a Laravel',
            'description' => 'Sèrie de vídeos sobre Laravel',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear un vídeo associat a la sèrie
        Video::create([
            'title' => 'Exemple de vídeo a Laravel',
            'description' => 'Aquest és un exemple de vídeo amb Laravel utilitzant l\'URL proporcionada.',
            'url' => 'https://www.youtube.com/watch?v=PGQxIILBb7M',
            'published_at' => now(),
            'previous' => null,
            'next' => null,
            'series_id' => $seriesId,
        ]);
    }
}
