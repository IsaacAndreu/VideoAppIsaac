<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\DefaultUsers;
use App\Helpers\DefaultVideos;
use App\Helpers\VideoPermissionsHelper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createPermissions();

        DefaultUsers::createSuperAdminUser();
        DefaultUsers::createRegularUser();
        DefaultUsers::createVideoManagerUser();

        DefaultVideos::crearVideosPerDefecte();

        // Crida al helper per crear i assignar permisos per als vídeos
        VideoPermissionsHelper::createAndAssignVideoPermissions();

        $this->command->info('✅ Usuaris, vídeos i permisos per defecte creats correctament!');
    }

    /**
     * Crea permisos i rols utilitzant Spatie Permission.
     */
    private function createPermissions(): void
    {
        $permissions = [
            'view videos',
            'edit videos',
            'delete videos',
            'manage videos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'super-admin'   => $permissions,
            'video-manager' => ['view videos', 'edit videos', 'manage videos'],
            'regular-user'  => ['view videos'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
