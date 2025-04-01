<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Helpers\DefaultUsers;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Comprova si la funció isSuperAdmin() retorna true per a un usuari amb super_admin = true.
     */
    public function test_user_is_super_admin()
    {
        $user = User::factory()->create([
            'super_admin' => true,
        ]);

        $this->assertTrue($user->isSuperAdmin());
    }

    /**
     * Comprova si la funció isSuperAdmin() retorna false per a un usuari normal.
     */
    public function test_user_is_not_super_admin()
    {
        $user = User::factory()->create([
            'super_admin' => false,
        ]);

        $this->assertFalse($user->isSuperAdmin());
    }

    // ------------------------------
    // NOVES FUNCIONS DEMANADES
    // ------------------------------

    /**
     * user_without_permissions_can_see_default_users_page
     */
    public function test_user_without_permissions_can_see_default_users_page()
    {
        $user = DefaultUsers::createRegularUser();
        $this->actingAs($user);

        $response = $this->get('/users');
        $response->assertStatus(200);
        // Comprova que mostra la llista d'usuaris
    }

    /**
     * user_with_permissions_can_see_default_users_page
     */
    public function test_user_with_permissions_can_see_default_users_page()
    {
        $user = DefaultUsers::createSuperAdminUser();
        // o createVideoManagerUser() si "manage users" està al superadmin o a un altre rol
        $this->actingAs($user);

        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    /**
     * not_logged_users_cannot_see_default_users_page
     */
    public function test_not_logged_users_cannot_see_default_users_page()
    {
        // Sense login
        $response = $this->get('/users');
        // Si en el teu codi real, un no logejat rep un 302 al login:
        $response->assertRedirect('/login');
        // O si reps un 403, fes:
        // $response->assertStatus(403);
    }

    /**
     * user_without_permissions_can_see_user_show_page
     */
    public function test_user_without_permissions_can_see_user_show_page()
    {
        $user = DefaultUsers::createRegularUser();
        $this->actingAs($user);

        // Creem un altre usuari per mostrar
        $otherUser = User::factory()->create();

        $response = $this->get('/users/' . $otherUser->id);
        $response->assertStatus(200);
    }

    /**
     * user_with_permissions_can_see_user_show_page
     */
    public function test_user_with_permissions_can_see_user_show_page()
    {
        $user = DefaultUsers::createSuperAdminUser();
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $response = $this->get('/users/' . $otherUser->id);
        $response->assertStatus(200);
    }

    /**
     * not_logged_users_cannot_see_user_show_page
     */
    public function test_not_logged_users_cannot_see_user_show_page()
    {
        $otherUser = User::factory()->create();

        $response = $this->get('/users/' . $otherUser->id);
        // si el codi real fa un redirect a /login:
        $response->assertRedirect('/login');
        // o un 403:
        // $response->assertStatus(403);
    }
}
