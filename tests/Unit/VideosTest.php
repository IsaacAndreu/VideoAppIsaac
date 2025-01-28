<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Carbon;

class VideosTest extends TestCase
{
    public function test_can_get_formatted_published_at_date()
    {
        Carbon::setLocale('ca'); // Estableix l'idioma a català

        $video = new class {
            public $published_at;

            public function getFormattedPublishedAtAttribute()
            {
                return $this->published_at
                    ? $this->published_at->translatedFormat('d') . ' de ' . $this->published_at->translatedFormat('F') . ' de ' . $this->published_at->translatedFormat('Y')
                    : null;
            }

        };

        $video->published_at = Carbon::create(2025, 1, 15, 10, 0, 0);

        $this->assertEquals('15 de gener de 2025', $video->getFormattedPublishedAtAttribute());
    }

    public function test_can_get_formatted_published_at_date_when_not_published()
    {
        $video = new class {
            public $published_at;

            public function getFormattedPublishedAtAttribute()
            {
                return $this->published_at
                    ? $this->published_at->translatedFormat('d') . ' de ' . $this->published_at->translatedFormat('F') . ' de ' . $this->published_at->translatedFormat('Y')
                    : null;
            }
        };

        $video->published_at = null;

        $this->assertNull($video->getFormattedPublishedAtAttribute());
    }
}
