<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\VideoPermissionsHelper;
use App\Helpers\SeriesPermissionsHelper;
use App\Helpers\UserPermissionsHelper;
use App\Helpers\DefaultUsers;
use App\Helpers\DefaultVideos;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Crear i assignar permisos de vídeos
        VideoPermissionsHelper::createAndAssignVideoPermissions();

        // 2) Crear i assignar permisos de sèries
        SeriesPermissionsHelper::createAndAssignSeriesPermissions();

        // 3) Crear i assignar permisos d’usuaris
        UserPermissionsHelper::seedDefaultPermissions();

        // 4) Crear usuaris per defecte
        DefaultUsers::createSuperAdminUser();
        DefaultUsers::createRegularUser();
        DefaultUsers::createVideoManagerUser();

        // 5) Crear vídeos per defecte
        DefaultVideos::crearVideosPerDefecte();

        $this->command->info('✅ Seed complet: permisos, usuaris i vídeos creats correctament.');
    }
}
