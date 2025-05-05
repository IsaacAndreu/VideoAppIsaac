<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeriesManageControllerTest extends TestCase
{
    use RefreshDatabase;

    private function loginAsVideoManager()
    {
        $user = User::factory()->create();
        $user->assignRole('videomanager');
        $this->actingAs($user);
        return $user;
    }

    private function loginAsSuperAdmin()
    {
        $user = User::factory()->create();
        $user->assignRole('superadmin');
        $this->actingAs($user);
        return $user;
    }

    private function loginAsRegularUser()
    {
        $user = User::factory()->create();
        $user->assignRole('regular');
        $this->actingAs($user);
        return $user;
    }

    public function test_user_with_permissions_can_see_add_series()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
        $response->assertSee('Crear nova sèrie');
    }

    public function test_user_without_series_manage_create_cannot_see_add_series()
    {
        $this->loginAsRegularUser();

        $response = $this->get(route('series.manage.index'));
        $response->assertDontSee('Crear nova sèrie');
    }

    public function test_user_with_permissions_can_store_series()
    {
        $this->loginAsSuperAdmin();

        $response = $this->post(route('series.manage.store'), [
            'title' => 'Nova sèrie',
            'description' => 'Descripció sèrie',
            'user_name' => 'Super Admin',
        ]);

        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseHas('series', [
            'title' => 'Nova sèrie',
        ]);
    }

    public function test_user_without_permissions_cannot_store_series()
    {
        $this->loginAsRegularUser();

        $response = $this->post(route('series.manage.store'), [
            'title' => 'Prova',
            'description' => 'Prova desc.',
            'user_name' => 'Usuari regular',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_destroy_series()
    {
        $this->loginAsSuperAdmin();
        $serie = Serie::factory()->create();

        $response = $this->delete(route('series.manage.destroy', $serie->id));
        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseMissing('series', ['id' => $serie->id]);
    }

    public function test_user_without_permissions_cannot_destroy_series()
    {
        $this->loginAsRegularUser();
        $serie = Serie::factory()->create();

        $response = $this->delete(route('series.manage.destroy', $serie->id));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_see_edit_series()
    {
        $this->loginAsSuperAdmin();
        $serie = Serie::factory()->create();

        $response = $this->get(route('series.manage.edit', $serie->id));
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_series()
    {
        $this->loginAsRegularUser();
        $serie = Serie::factory()->create();

        $response = $this->get(route('series.manage.edit', $serie->id));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_series()
    {
        $this->loginAsSuperAdmin();
        $serie = Serie::factory()->create();

        $response = $this->put(route('series.manage.update', $serie->id), [
            'title' => 'Nou títol',
            'description' => $serie->description,
            'user_name' => $serie->user_name,
        ]);

        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseHas('series', ['title' => 'Nou títol']);
    }

    public function test_user_without_permissions_cannot_update_series()
    {
        $this->loginAsRegularUser();
        $serie = Serie::factory()->create();

        $response = $this->put(route('series.manage.update', $serie->id), [
            'title' => 'No permès',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_manage_series()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_series()
    {
        $this->loginAsRegularUser();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_series()
    {
        $response = $this->get(route('series.manage.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_videomanagers_can_manage_series()
    {
        $this->loginAsVideoManager();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }

    public function test_superadmins_can_manage_series()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }
}
