<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\DefaultUsers;
use App\Helpers\DefaultVideos;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Crear permisos i rols abans d'assignar-los als usuaris
        $this->createPermissions();
        $this->command->info('✔️ S\'han creat els permisos i rols correctament.');

        // Crear usuaris per defecte
        if (class_exists(DefaultUsers::class)) {
            DefaultUsers::crearUsuariPerDefecte();
            DefaultUsers::crearProfessorPerDefecte();
            $this->createSuperAdminUser();
            $this->createRegularUser();
            $this->createVideoManagerUser();
            $this->command->info('✔️ S\'han creat els usuaris per defecte correctament.');
        } else {
            $this->command->error('❌ La classe DefaultUsers no existeix.');
        }

        // Crear vídeos per defecte
        if (class_exists(DefaultVideos::class)) {
            $defaultVideos = new DefaultVideos();
            $defaultVideos->crearVideoPerDefecte();
            $this->command->info('✔️ S\'han creat els vídeos per defecte.');
        } else {
            $this->command->error('❌ La classe DefaultVideos no existeix.');
        }

        // Definir Gates
        $this->defineGates();
        $this->command->info('✔️ S\'han definit les portes d\'accés correctament.');

        $this->command->info('✅ La base de dades s\'ha inicialitzat correctament!');
    }

    /**
     * Crea un usuari SuperAdmin.
     */
    private function createSuperAdminUser(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@videosapp.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('123456789'),
                'super_admin' => true
            ]
        );

        if (!$superAdmin->hasRole('super-admin')) {
            $superAdmin->assignRole('super-admin');
        }
    }

    /**
     * Crea un usuari regular.
     */
    private function createRegularUser(): void
    {
        $regularUser = User::firstOrCreate(
            ['email' => 'regular@videosapp.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('123456789'),
                'super_admin' => false
            ]
        );

        if (!$regularUser->hasRole('regular-user')) {
            $regularUser->assignRole('regular-user');
        }
    }

    /**
     * Crea un usuari Video Manager.
     */
    private function createVideoManagerUser(): void
    {
        $videoManager = User::firstOrCreate(
            ['email' => 'videosmanager@videosapp.com'],
            [
                'name' => 'Video Manager',
                'password' => bcrypt('123456789'),
                'super_admin' => false
            ]
        );

        if (!$videoManager->hasRole('video-manager')) {
            $videoManager->assignRole('video-manager');
        }
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
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear rols i assignar permisos
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $regularUserRole = Role::firstOrCreate(['name' => 'regular-user']);
        $videoManagerRole = Role::firstOrCreate(['name' => 'video-manager']);

        // Assignar permisos només si no estan assignats ja
        if ($superAdminRole->permissions->isEmpty()) {
            $superAdminRole->givePermissionTo($permissions);
        }
        if ($videoManagerRole->permissions->isEmpty()) {
            $videoManagerRole->givePermissionTo(['view videos', 'edit videos']);
        }
        if ($regularUserRole->permissions->isEmpty()) {
            $regularUserRole->givePermissionTo(['view videos']);
        }
    }

    /**
     * Defineix les Gates per gestionar permisos.
     */
    private function defineGates(): void
    {
        Gate::define('manage-videos', function (User $user) {
            return $user->hasRole('video-manager') || $user->hasRole('super-admin');
        });

        Gate::define('delete-videos', function (User $user) {
            return $user->hasRole('super-admin');
        });
    }
}
