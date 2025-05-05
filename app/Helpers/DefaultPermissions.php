<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use App\Models\User;

class DefaultPermissions
{
    /**
     * Crea els permisos de gestió de sèries i els assigna als superadmins.
     */
    public static function create_series_permissions(): void
    {
        $permissions = [
            'series.manage',
            'series.create',
            'series.edit',
            'series.delete',
            'series.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assignar permisos a tots els superadmins
        $superadmins = User::role('superadmin')->get();

        foreach ($superadmins as $user) {
            $user->givePermissionTo($permissions);
        }
    }
}
