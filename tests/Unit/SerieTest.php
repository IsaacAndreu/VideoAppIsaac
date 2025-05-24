<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SerieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function serie_has_many_videos()
    {
        $serie = Serie::factory()->create();
        $videos = Video::factory()->count(2)->create([
            'serie_id' => $serie->id,
        ]);

        $this->assertCount(2, $serie->videos);
        $this->assertTrue($serie->videos->contains($videos->first()));
    }

    /** @test */
    public function it_has_expected_fillable_properties()
    {
        $serie = new Serie();

        $this->assertEquals(
            ['title', 'description', 'image', 'user_name', 'user_photo_url', 'published_at'],
            $serie->getFillable()
        );
    }

    /** @test */
    public function title_and_description_are_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Serie::create([]);
    }
}
