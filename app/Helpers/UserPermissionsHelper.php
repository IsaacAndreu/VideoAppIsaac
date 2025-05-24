<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionsHelper
{
    /**
     * Seed dels permisos per a usuaris, sèries i vídeos,
     * i assignació de tots ells al rol super-admin.
     *
     * @return void
     */
    public static function seedDefaultPermissions(): void
    {
        $permissions = [
            // Sèries
            'view series',
            'create series',
            'edit series',
            'delete series',
            'manage series',
            // Vídeos
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'manage videos',
            // Usuaris
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',
        ];

        // 1. Crear tots els permisos si no existeixen
        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name'       => $name,
                'guard_name' => 'web',
            ]);
        }

        // 2. Obtenir o crear el rol super-admin
        $superAdmin = Role::firstOrCreate([
            'name'       => 'super-admin',
            'guard_name' => 'web',
        ]);

        // 3. Assignar-li TOTS els permisos
        $superAdmin->syncPermissions($permissions);
    }

    /**
     * Retorna la llista de tots els noms de permisos disponibles.
     *
     * @return string[]
     */
    public static function getAllPermissions(): array
    {
        return Permission::pluck('name')->toArray();
    }
}
