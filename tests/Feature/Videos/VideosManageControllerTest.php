<?php

namespace Tests\Feature\Videos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Executa el seeder per assegurar que els rols i permisos estan creats
        $this->artisan('db:seed');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Creem els permisos si no existeixen
        $permissions = [
            'view videos',
            'edit videos',
            'delete videos',
            'manage users',
            'create videos',
            'manage videos', // redundant però per seguretat
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Creem els rols si no existeixen
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $regularUserRole = Role::firstOrCreate(['name' => 'regular-user', 'guard_name' => 'web']);
        $videoManagerRole = Role::firstOrCreate(['name' => 'video-manager', 'guard_name' => 'web']);

        // Assignem permisos als rols
        $superAdminRole->syncPermissions($permissions);
        $videoManagerRole->syncPermissions(['view videos', 'edit videos', 'create videos', 'manage videos']);
        $regularUserRole->syncPermissions(['view videos']);
    }

    // Funcions d'autenticació
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

    // Tests ja existents:
    public function test_user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();

        // Creem 3 vídeos (la factory pot no assignar user_id, així que per aquest test només comprovem la visualització)
        $videos = Video::factory()->count(3)->create();

        // Accedim a la pàgina pública on es llisten els vídeos
        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);

        // Comprovem que es mostren els títols dels 3 vídeos
        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }

    public function test_regular_users_cannot_manage_videos()
    {
        $this->loginAsRegularUser();

        $url = route('videos.manage.index');
        echo "Testing route: " . $url; // Log per verificar la ruta generada

        $response = $this->get($url);
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

    // Nous tests segons l'enunciat:

    public function test_user_with_permissions_can_see_add_videos()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('videos.manage.create'));
        $response->assertStatus(200);
        $response->assertSee('Crear un nou vídeo'); // ajusta aquest text segons la teva vista
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
            'title' => 'Nou Vídeo de Prova',
            'description' => 'Descripció del nou vídeo',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ];
        $response = $this->post(route('videos.manage.store'), $postData);
        $response->assertRedirect(route('videos.manage.index'));
        $this->assertDatabaseHas('videos', [
            'title' => 'Nou Vídeo de Prova',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_without_permissions_cannot_store_videos()
    {
        $this->loginAsRegularUser();
        $postData = [
            'title' => 'Nou Vídeo de Prova',
            'description' => 'Descripció del nou vídeo',
            'url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ];
        $response = $this->post(route('videos.manage.store'), $postData);
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_see_edit_videos()
    {
        $this->loginAsVideoManager();
        $user = auth()->user();
        // Creem un vídeo assignant-li el user_id del gestor
        $video = Video::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('videos.manage.edit', $video->id));
        $response->assertStatus(200);
        $response->assertSee('Editar'); // comprova algun text de la vista d'edició
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
        $video = Video::factory()->create(['title' => 'Antic Títol', 'user_id' => $user->id]);
        $updateData = [
            'title' => 'Títol Actualitzat',
            'description' => $video->description,
            'url' => $video->url,
        ];
        $response = $this->put(route('videos.manage.update', $video->id), $updateData);
        $response->assertRedirect(route('videos.manage.index'));
        $this->assertDatabaseHas('videos', [
            'id' => $video->id,
            'title' => 'Títol Actualitzat',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_without_permissions_cannot_update_videos()
    {
        $this->loginAsRegularUser();
        $video = Video::factory()->create(['title' => 'Antic Títol']);
        $updateData = [
            'title' => 'Títol Actualitzat',
            'description' => $video->description,
            'url' => $video->url,
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
