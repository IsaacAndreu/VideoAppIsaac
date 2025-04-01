<?php

namespace Tests\Feature\Videos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Video;
use App\Helpers\DefaultUsers;
use Database\Seeders\DatabaseSeeder;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_not_logged_users_can_see_default_videos_page()
    {
        // Es creen 3 vídeos amb usuaris automàtics gràcies a la factory
        $videos = Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);

        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    public function test_user_without_permissions_can_see_default_videos_page()
    {
        $user = DefaultUsers::createRegularUser();
        $this->assertNotNull($user->currentTeam);
        $this->actingAs($user);

        $videos = Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);

        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    public function test_user_with_permissions_can_see_default_videos_page()
    {
        $user = DefaultUsers::createVideoManagerUser();
        $this->assertNotNull($user->currentTeam);
        $this->actingAs($user);

        $videos = Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);

        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    public function test_users_cannot_view_not_existing_videos()
    {
        $user = DefaultUsers::createRegularUser();
        $this->assertNotNull($user->currentTeam);
        $this->actingAs($user);

        $response = $this->get('/videos/999'); // ID inexistent
        $response->assertStatus(404);
    }
}
