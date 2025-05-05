<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SerieTest extends TestCase
{
    use RefreshDatabase;

    public function test_serie_have_videos()
    {
        $serie = Serie::factory()->create();
        $video = Video::factory()->create([
            'series_id' => $serie->id,
        ]);

        $this->assertTrue($serie->videos->contains($video));
    }
}
