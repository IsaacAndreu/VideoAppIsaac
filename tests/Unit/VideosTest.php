<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video;
use Illuminate\Support\Carbon;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_formatted_published_at_date()
    {
        Carbon::setLocale('ca');

        $video = Video::factory()->create([
            'published_at' => Carbon::create(2025, 1, 15, 10, 0, 0),
        ]);

        $this->assertEquals('15 de gener de 2025', $video->formatted_published_at);
    }

    public function test_can_get_formatted_published_at_date_when_not_published()
    {
        $video = Video::factory()->create([
            'published_at' => null,
        ]);

        $this->assertNull($video->formatted_published_at);
    }
}
