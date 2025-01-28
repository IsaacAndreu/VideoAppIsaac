<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\DefaultUsers;
use App\Helpers\DefaultVideos;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Crear usuari per defecte
        if (class_exists(DefaultUsers::class)) {
            DefaultUsers::crearUsuariPerDefecte();
            DefaultUsers::crearProfessorPerDefecte();
        } else {
            $this->command->error('La classe DefaultUsers no existeix.');
        }

        // Crear vídeos per defecte
        if (class_exists(DefaultVideos::class)) {
            $defaultVideos = new DefaultVideos();
            $defaultVideos->crearVideoPerDefecte();
        } else {
            $this->command->error('La classe DefaultVideos no existeix.');
        }

        $this->command->info('La base de dades sha inicialitzat correctament!');
    }
}

