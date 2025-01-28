<?php

namespace Tests\Feature\Videos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video;
use App\Models\User;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_view_videos()
    {
        $this->actingAs(User::factory()->create());

        $video = Video::factory()->create([
            'title' => 'Test Video',
            'description' => 'This is a test video.',
            'url' => 'https://www.example.com/video',
        ]);

        $response = $this->get("/videos/{$video->id}");

        $response->assertStatus(200);
        $response->assertSee($video->title);
        $response->assertSee($video->description);
    }

    public function test_users_cannot_view_not_existing_videos()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/videos/999'); // Assume 999 is a non-existent ID

        $response->assertStatus(404);
    }
}
