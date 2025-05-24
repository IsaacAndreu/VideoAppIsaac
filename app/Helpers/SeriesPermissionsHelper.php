<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeriesPermissionsHelper
{
    /**
     * Crea els permisos de sèries i els assigna als rols corresponents.
     *
     * @return void
     */
    public static function createAndAssignSeriesPermissions(): void
    {
        // 1) Defineix els permisos de sèries
        $permissions = [
            'view series',
            'create series',
            'edit series',    // abans era 'update series'
            'delete series',
            'manage series',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name'       => $name,
                'guard_name' => 'web',
            ]);
        }

        // 2) Obté (o crea) els rols
        $superAdmin = Role::firstOrCreate([
            'name'       => 'super-admin',
            'guard_name' => 'web',
        ]);
        $regular = Role::firstOrCreate([
            'name'       => 'regular',
            'guard_name' => 'web',
        ]);

        // 3) Assigna tots els permisos al super-admin
        $superAdmin->syncPermissions($permissions);

        // 4) Assigna només view/create al rol regular
        $regular->syncPermissions([
            'view series',
            'create series',
        ]);
    }
}
