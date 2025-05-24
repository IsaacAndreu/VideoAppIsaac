<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Spatie\Permission\PermissionRegistrar;

class UsersManageControllerTest extends TestCase
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

    public function test_user_with_permissions_can_manage_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_users()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_users()
    {
        $response = $this->get(route('users.manage.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_with_permissions_can_see_add_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.create'));
        $response->assertStatus(200);
        $response->assertSee('Crear un nou usuari');
    }

    public function test_user_without_users_manage_create_cannot_see_add_users()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.create'));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_users()
    {
        $this->loginAsSuperAdmin();
        $postData = [
            'name'        => 'Nou Usuari',
            'email'       => 'nou@example.com',
            'password'    => '12345678',
            'role'        => 'regular-user',
            'permissions' => [],
        ];
        $response = $this->post(route('users.manage.store'), $postData);
        $response->assertRedirect(route('users.manage.index'));
        $this->assertDatabaseHas('users', [
            'name'  => 'Nou Usuari',
            'email' => 'nou@example.com',
        ]);
    }

    public function test_user_without_permissions_cannot_store_users()
    {
        $this->loginAsRegularUser();
        $postData = [
            'name'        => 'Sense Permís',
            'email'       => 'sense@example.com',
            'password'    => '12345678',
            'role'        => 'regular-user',
            'permissions' => [],
        ];
        $response = $this->post(route('users.manage.store'), $postData);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', [
            'email' => 'sense@example.com',
        ]);
    }

    public function test_user_with_permissions_can_see_edit_users()
    {
        $this->loginAsSuperAdmin();
        $anotherUser = User::factory()->create();
        $response = $this->get(route('users.manage.edit', $anotherUser->id));
        $response->assertStatus(200);
        $response->assertSee('Editar usuari');
    }

    public function test_user_without_permissions_cannot_see_edit_users()
    {
        $this->loginAsRegularUser();
        $anotherUser = User::factory()->create();
        $response = $this->get(route('users.manage.edit', $anotherUser->id));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_users()
    {
        $this->loginAsSuperAdmin();
        $anotherUser = User::factory()->create([
            'name'  => 'Antic Usuari',
            'email' => 'antic@example.com',
        ]);
        $updateData = [
            'name'        => 'Nou Nom',
            'email'       => 'nou@example.com',
            'role'        => 'regular-user',
            'permissions' => [],
        ];
        $response = $this->put(route('users.manage.update', $anotherUser->id), $updateData);
        $response->assertRedirect(route('users.manage.index'));
        $this->assertDatabaseHas('users', [
            'id'    => $anotherUser->id,
            'name'  => 'Nou Nom',
            'email' => 'nou@example.com',
        ]);
    }

    public function test_user_without_permissions_cannot_update_users()
    {
        $this->loginAsRegularUser();
        $anotherUser = User::factory()->create([
            'name'  => 'Antic',
            'email' => 'antic@example.com',
        ]);
        $updateData = [
            'name'  => 'NOU NOM',
            'email' => 'nou@example.com',
        ];
        $response = $this->put(route('users.manage.update', $anotherUser->id), $updateData);
        $response->assertStatus(403);
        $this->assertDatabaseHas('users', [
            'name'  => 'Antic',
            'email' => 'antic@example.com',
        ]);
    }

    public function test_user_with_permissions_can_destroy_users()
    {
        $this->loginAsSuperAdmin();
        $anotherUser = User::factory()->create();
        $response = $this->delete(route('users.manage.destroy', $anotherUser->id));
        $response->assertRedirect(route('users.manage.index'));
        $this->assertDatabaseMissing('users', ['id' => $anotherUser->id]);
    }

    public function test_user_without_permissions_cannot_destroy_users()
    {
        $this->loginAsRegularUser();
        $anotherUser = User::factory()->create();
        $response = $this->delete(route('users.manage.destroy', $anotherUser->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $anotherUser->id]);
    }
}
