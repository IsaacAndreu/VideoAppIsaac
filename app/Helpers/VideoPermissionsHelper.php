<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class VideoPermissionsHelper
{
    /**
     * Crea i assigna els permisos per al CRUD de vídeos, gestió d'usuaris i sèries.
     *
     * @return void
     */
    public static function createAndAssignVideoPermissions(): void
    {
        // Permisos definits per a vídeos, usuaris i sèries
        $permissions = [
            // Vídeos
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos',

            // Usuaris
            'manage users',

            // Sèries
            'view series',
            'create series',
            'edit series',
            'delete series',
            'manage series',
        ];

        // Crear tots els permisos si no existeixen
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Crear els rols si no existeixen
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'video-manager', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'regular-user', 'guard_name' => 'web']);

        // Assignar permisos al rol super-admin
        Role::findByName('super-admin', 'web')->syncPermissions($permissions);

        // Assignar permisos al rol video-manager
        Role::findByName('video-manager', 'web')->syncPermissions([
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos',
        ]);

        // Assignar permisos al rol regular-user
        Role::findByName('regular-user', 'web')->syncPermissions([
            'view videos',
            'view series',
        ]);
    }
}
