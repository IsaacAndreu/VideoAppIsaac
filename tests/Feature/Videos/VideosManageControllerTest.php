<?php

namespace Tests\Feature\Videos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 🛠️ Creem els rols i permisos abans de cada test per evitar l'error "RoleDoesNotExist"
        $this->artisan('db:seed');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Creem els permisos si no existeixen
        $permissions = [
            'view videos',
            'edit videos',
            'delete videos',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Creem els rols si no existeixen
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $regularUserRole = Role::firstOrCreate(['name' => 'regular-user', 'guard_name' => 'web']);
        $videoManagerRole = Role::firstOrCreate(['name' => 'video-manager', 'guard_name' => 'web']);

        // Assignem permisos als rols
        $superAdminRole->givePermissionTo($permissions);
        $videoManagerRole->givePermissionTo(['view videos', 'edit videos']);
        $regularUserRole->givePermissionTo(['view videos']);
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

        $video = Video::factory()->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);
        $response->assertSee($video->title);
    }

    public function test_regular_users_cannot_manage_videos()
    {
        $this->loginAsRegularUser();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_videos()
    {
        $response = $this->get(route('videos.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();

        $video = Video::factory()->create();

        $response = $this->get(route('videos.index'));
        $response->assertStatus(200);
        $response->assertSee($video->title);
    }
}
