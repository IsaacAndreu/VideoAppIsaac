<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class VideoPermissionsHelper
{
    /**
     * Crea i assigna els permisos per al CRUD de vídeos i la gestió d'usuaris a través dels rols.
     *
     * @return void
     */
    public static function createAndAssignVideoPermissions(): void
    {
        // Defineix els permisos per als vídeos i usuaris
        $permissions = [
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos',
            'manage users', // Afegit per gestionar usuaris
        ];

        // Crea els permisos per al guard 'web'
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Obté o crea els rols corresponents amb el guard 'web'
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $videoManagerRole = Role::firstOrCreate(['name' => 'video-manager', 'guard_name' => 'web']);
        $regularUserRole = Role::firstOrCreate(['name' => 'regular-user', 'guard_name' => 'web']);

        // Assigna els permisos als rols
        // - super-admin té tots els permisos
        $superAdminRole->syncPermissions($permissions);

        // - video-manager té només permisos de vídeos (però NO 'manage users')
        $videoManagerRole->syncPermissions([
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos'
        ]);

        // - regular-user té només 'view videos' (no pot gestionar vídeos ni usuaris)
        $regularUserRole->syncPermissions(['view videos']);
    }
}
