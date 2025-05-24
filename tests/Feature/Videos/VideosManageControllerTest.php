<?php

namespace Tests\Feature\Videos;

use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Spatie\Permission\PermissionRegistrar;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles & permissions
        $this->seed(DatabaseSeeder::class);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    protected function loginAsSuperAdmin()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');
        $this->actingAs($user);
    }

    protected function loginAsVideoManager()
    {
        $user = User::factory()->create();
        $user->assignRole('video-manager');
        $this->actingAs($user);
    }

    protected function loginAsRegularUser()
    {
        $user = User::factory()->create();
        $user->assignRole('regular-user');
        $this->actingAs($user);
    }

    public function test_user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();
        $videos = Video::factory()->count(3)->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);

        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    public function test_regular_users_cannot_manage_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.manage.index'));
        $response->assertStatus(403);
    }

    public function test_guest_users_can_view_default_videos_page()
    {
        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);
    }

    public function test_superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();
        $video = Video::factory()->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);
        $response->assertSee($video->title);
    }

    public function test_user_with_permissions_can_see_add_videos()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('videos.manage.create'));
        $response->assertStatus(200);
        $response->assertSee('Crear un nou vídeo');
    }

    public function test_user_without_videos_manage_create_cannot_see_add_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('videos.manage.create'));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_videos()
    {
        $this->loginAsVideoManager();
        $user = auth()->user();

        $postData = [
            'title'       => 'Nou Vídeo de Prova',
            'description' => 'Descripció del nou vídeo',
            'url'         => 'https://www.example.com',
        ];

        $response = $this->post(route('videos.manage.store'), $postData);
        $response->assertRedirect(route('videos.manage.index'));

        $this->assertDatabaseHas('videos', [
            'title'   => 'Nou Vídeo de Prova',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_without_permissions_cannot_store_videos()
    {
        $this->loginAsRegularUser();

        $postData = [
            'title'       => 'Nou Vídeo de Prova',
            'description' => 'Descripció del nou vídeo',
            'url'         => 'https://www.example.com',
        ];

        $response = $this->post(route('videos.manage.store'), $postData);
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_see_edit_videos()
    {
        $this->loginAsVideoManager();
        $user = auth()->user();
        $video = Video::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('videos.manage.edit', $video->id));
        $response->assertStatus(200);
        $response->assertSee('Editar');
    }

    public function test_user_without_permissions_cannot_see_edit_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();

        $response = $this->get(route('videos.manage.edit', $video->id));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_videos()
    {
        $this->loginAsVideoManager();
        $user = auth()->user();
        $video = Video::factory()->create(['user_id' => $user->id, 'title' => 'Antic Títol']);

        $updateData = [
            'title'       => 'Títol Actualitzat',
            'description' => $video->description,
            'url'         => $video->url,
        ];

        $response = $this->put(route('videos.manage.update', $video->id), $updateData);
        $response->assertRedirect(route('videos.manage.index'));

        $this->assertDatabaseHas('videos', [
            'id'    => $video->id,
            'title' => 'Títol Actualitzat',
        ]);
    }

    public function test_user_without_permissions_cannot_update_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create(['title' => 'Antic Títol']);

        $updateData = [
            'title'       => 'Títol Actualitzat',
            'description' => $video->description,
            'url'         => $video->url,
        ];

        $response = $this->put(route('videos.manage.update', $video->id), $updateData);
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_destroy_videos()
    {
        $this->loginAsVideoManager();
        $user = auth()->user();
        $video = Video::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('videos.manage.destroy', $video->id));
        $response->assertRedirect(route('videos.manage.index'));

        $this->assertDatabaseMissing('videos', ['id' => $video->id]);
    }

    public function test_user_without_permissions_cannot_destroy_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create();

        $response = $this->delete(route('videos.manage.destroy', $video->id));
        $response->assertStatus(403);
    }
}
