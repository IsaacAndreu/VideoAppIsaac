<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionsHelper
{
    /**
     * Crea i assigna el permís de "manage users" al rol super-admin.
     *
     * @return void
     */
    public static function createAndAssignUserPermissions(): void
    {
        // 1. Defineix el permís per a la gestió dels usuaris
        $manageUsersPermission = Permission::firstOrCreate([
            'name' => 'manage users',
            'guard_name' => 'web',
        ]);

        // 2. Obté el rol super-admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        // 3. Assigna el permís de "manage users" només al rol super-admin
        $superAdminRole->givePermissionTo($manageUsersPermission);
    }
}
