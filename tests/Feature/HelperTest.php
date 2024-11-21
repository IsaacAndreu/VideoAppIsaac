<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class HelperTest extends TestCase
{
    use RefreshDatabase;

    public function test_creacio_usuari_per_defecte()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'Usuari Defecte',
            'email' => 'usuari@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Act & Assert
        $this->assertDatabaseHas('users', [
            'name' => 'Usuari Defecte',
            'email' => 'usuari@example.com',
        ]);
    }

    public function test_creacio_professor_per_defecte()
    {
        // Arrange
        $professor = User::factory()->create([
            'name' => 'Professor Defecte',
            'email' => 'professor@example.com',
            'password' => bcrypt('password456'),
        ]);

        // Act & Assert
        $this->assertDatabaseHas('users', [
            'name' => 'Professor Defecte',
            'email' => 'professor@example.com',
        ]);
    }
}
