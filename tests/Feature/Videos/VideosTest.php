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
        // Executa el seeder per assegurar que els rols i permisos estan creats
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Comprova que els usuaris no autenticats (guests) poden veure la pàgina d'índex de vídeos.
     */
    public function test_not_logged_users_can_see_default_videos_page()
    {
        // Creem 3 vídeos per defecte
        $videos = Video::factory()->count(3)->create();

        // Sense autenticar, accedim a la pàgina d'índex (pública)
        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);

        // Comprovem que apareixen els títols dels vídeos
        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    /**
     * Comprova que un usuari sense permisos addicionals (regular user)
     * pot veure la pàgina d'índex de vídeos (pública).
     */
    public function test_user_without_permissions_can_see_default_videos_page()
    {
        $user = DefaultUsers::createRegularUser();
        $this->assertNotNull($user->currentTeam, 'L\'usuari hauria de tenir un Team assignat.');
        $this->actingAs($user);

        $videos = Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);
        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    /**
     * Comprova que un usuari amb permisos (video manager o super-admin)
     * pot veure la pàgina d'índex de vídeos (pública).
     */
    public function test_user_with_permissions_can_see_default_videos_page()
    {
        // Utilitzem un usuari amb el rol de video-manager
        $user = DefaultUsers::createVideoManagerUser();
        $this->actingAs($user);

        $videos = Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);
        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    /**
     * Comprova que, en intentar veure un vídeo inexistent, es retorna un 404.
     */
    public function test_users_cannot_view_not_existing_videos()
    {
        $user = DefaultUsers::createRegularUser();
        $this->actingAs($user);

        $response = $this->get('/videos/999'); // Assumeix que 999 és un ID inexistent
        $response->assertStatus(404);
    }
}
