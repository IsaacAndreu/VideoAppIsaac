<?php

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Executem el seeder, si cal
        $this->artisan('db:seed');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Creem permisos addicionals si no els tens al seeder
        $permissions = [
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Creem rols si no existeixen
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $regularUserRole = Role::firstOrCreate(['name' => 'regular-user', 'guard_name' => 'web']);
        $videoManagerRole = Role::firstOrCreate(['name' => 'video-manager', 'guard_name' => 'web']);

        // Assignem permisos als rols
        $superAdminRole->givePermissionTo('manage users');
        // regular-user -> sense manage users
        // video-manager -> sense manage users, excepte si vols que també pugui
    }

    // ------------------
    // Funcions de login
    // ------------------

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

    // -------------------------------------------------------------------
    // Tests
    // -------------------------------------------------------------------

    public function test_user_with_permissions_can_manage_users()
    {
        $this->loginAsSuperAdmin(); // té manage users
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_users()
    {
        $this->loginAsRegularUser(); // no té manage users
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_users()
    {
        // sense actingAs
        $response = $this->get(route('users.manage.index'));
        // segons la teva lògica, pot ser un redirect a /login
        $response->assertRedirect(route('login'));
    }

    public function test_superadmins_can_manage_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }

    // ----------- CREATE (veure la pàgina de creació) -----------
    public function test_user_with_permissions_can_see_add_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.create'));
        $response->assertStatus(200);
        $response->assertSee('Crear un nou usuari'); // Ajusta segons la teva vista
    }

    public function test_user_without_users_manage_create_cannot_see_add_users()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.create'));
        $response->assertStatus(403);
    }

    // ----------- STORE (crear un usuari) -----------
    public function test_user_with_permissions_can_store_users()
    {
        $this->loginAsSuperAdmin();
        $postData = [
            'name' => 'Nou Usuari',
            'email' => 'nou@example.com',
            'password' => '12345678',
        ];

        $response = $this->post(route('users.manage.store'), $postData);
        $response->assertRedirect(route('users.manage.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Nou Usuari',
            'email' => 'nou@example.com',
        ]);
    }

    public function test_user_without_permissions_cannot_store_users()
    {
        $this->loginAsRegularUser();
        $postData = [
            'name' => 'Usuari sense permís',
            'email' => 'sense@example.com',
            'password' => '12345678',
        ];
        $response = $this->post(route('users.manage.store'), $postData);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', [
            'email' => 'sense@example.com'
        ]);
    }

    // ----------- EDIT (veure el formulari d'edició) -----------
    public function test_user_with_permissions_can_see_edit_users()
    {
        $this->loginAsSuperAdmin();
        $anotherUser = User::factory()->create();

        $response = $this->get(route('users.manage.edit', $anotherUser->id));
        $response->assertStatus(200);
        $response->assertSee('Editar usuari'); // ajusta al text que tinguis
    }

    public function test_user_without_permissions_cannot_see_edit_users()
    {
        $this->loginAsRegularUser();
        $anotherUser = User::factory()->create();

        $response = $this->get(route('users.manage.edit', $anotherUser->id));
        $response->assertStatus(403);
    }

    // ----------- UPDATE (actualitzar un usuari) -----------
    public function test_user_with_permissions_can_update_users()
    {
        $this->loginAsSuperAdmin();
        $anotherUser = User::factory()->create([
            'name' => 'Antic Usuari',
            'email' => 'antic@example.com',
        ]);

        $updateData = [
            'name' => 'Nou Nom',
            'email' => 'nou@example.com',
        ];

        $response = $this->put(route('users.manage.update', $anotherUser->id), $updateData);
        $response->assertRedirect(route('users.manage.index'));

        $this->assertDatabaseHas('users', [
            'id' => $anotherUser->id,
            'name' => 'Nou Nom',
            'email' => 'nou@example.com',
        ]);
    }

    public function test_user_without_permissions_cannot_update_users()
    {
        $this->loginAsRegularUser();
        $anotherUser = User::factory()->create([
            'name' => 'Antic',
            'email' => 'antic@example.com',
        ]);

        $updateData = [
            'name' => 'NOU NOM',
            'email' => 'nou@example.com',
        ];

        $response = $this->put(route('users.manage.update', $anotherUser->id), $updateData);
        $response->assertStatus(403);

        // assegurem que no s'ha actualitzat
        $this->assertDatabaseHas('users', [
            'name' => 'Antic',
            'email' => 'antic@example.com',
        ]);
    }

    // ----------- DESTROY (eliminar un usuari) -----------
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
