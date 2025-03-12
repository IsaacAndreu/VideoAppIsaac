<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

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
        $user = crearUsuariPerDefecte();

        $this->assertDatabaseHas('teams', [
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('team_user', [
            'team_id' => 1, // ID del team creat
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
    }
    public function test_create_default_video()
    {
        $defaultVideos = new \App\Helpers\DefaultVideos();
        $video = $defaultVideos->crearVideoPerDefecte();


        $this->assertDatabaseHas('videos', [
            'title' => 'Vídeo per defecte',
            'url' => 'https://example.com/default-video',
            'description' => 'Aquest és un vídeo per defecte.',
        ]);
    }

}
