<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Helpers\DefaultVideos;
use App\Helpers\DefaultUsers;

class HelperTest extends TestCase
{
    use RefreshDatabase;

    public function test_creacio_usuari_per_defecte()
    {
        $user = User::factory()->create([
            'name' => 'Usuari Defecte',
            'email' => 'usuari@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Usuari Defecte',
            'email' => 'usuari@example.com',
        ]);
    }

    public function test_creacio_professor_per_defecte()
    {
        $professor = User::factory()->create([
            'name' => 'Professor Defecte',
            'email' => 'professor@example.com',
            'password' => bcrypt('password456'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Professor Defecte',
            'email' => 'professor@example.com',
        ]);
    }

    public function test_creacio_usuari_associat_a_team()
    {
        $user = \App\Helpers\DefaultUsers::createRegularUser();

        $this->assertDatabaseHas('teams', [
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('team_user', [
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
    }

    public function test_create_default_video()
    {
        // Primer creem un usuari per associar-lo al vídeo
        $user = DefaultUsers::createVideoManagerUser();

        // Instanciem l'helper i passem l'usuari
        $defaultVideos = new DefaultVideos();
        $video = $defaultVideos->crearVideoPerDefecte($user);

        $this->assertDatabaseHas('videos', [
            'title' => 'Vídeo per defecte',
            'url' => 'https://example.com/default-video',
            'description' => 'Aquest és un vídeo per defecte.',
            'user_id' => $user->id,
        ]);
    }
}
