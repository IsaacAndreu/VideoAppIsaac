<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\DefaultUsers;
use App\Helpers\DefaultVideos;
use App\Helpers\VideoPermissionsHelper;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // 1) Crea permisos i rols per a vídeos i, dins del mateix helper, afegim 'manage users'
        VideoPermissionsHelper::createAndAssignVideoPermissions();

        // 2) Crea usuaris per defecte
        DefaultUsers::createSuperAdminUser();
        DefaultUsers::createRegularUser();
        DefaultUsers::createVideoManagerUser();

        // 3) Crea vídeos per defecte
        DefaultVideos::crearVideosPerDefecte();

        $this->command->info('✅ Usuaris, vídeos i permisos per defecte creats correctament!');
    }
}
