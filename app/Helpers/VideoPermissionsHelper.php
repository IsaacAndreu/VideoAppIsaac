<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class VideoPermissionsHelper
{
    /**
     * Crea i assigna els permisos per al CRUD de vídeos.
     *
     * @return void
     */
    public static function createAndAssignVideoPermissions(): void
    {
        // Defineix els permisos per als vídeos
        $permissions = [
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos',
        ];

        // Crea els permisos (si no existeixen) per al guard 'web'
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Obté o crea els rols corresponents
        $videoManagerRole = Role::firstOrCreate(['name' => 'video-manager', 'guard_name' => 'web']);
        $superAdminRole   = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $regularUserRole  = Role::firstOrCreate(['name' => 'regular-user', 'guard_name' => 'web']);

        // Assigna permisos als rols:
        // - El rol 'video-manager' rep tots els permisos relacionats amb els vídeos
        // - El rol 'super-admin' rep tots els permisos
        // - El rol 'regular-user' només rep el permís per veure vídeos
        $videoManagerRole->syncPermissions(['view videos', 'create videos', 'edit videos', 'delete videos', 'manage videos']);
        $superAdminRole->syncPermissions($permissions);
        $regularUserRole->syncPermissions(['view videos']);
    }
}
