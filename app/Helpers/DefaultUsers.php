<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Helpers\VideoPermissionsHelper;

class DefaultUsers
{
    /**
     * Crea un usuari Super Admin.
     *
     * @return User
     */
    public static function createSuperAdminUser(): User
    {
        $user = User::firstOrCreate([
            'email' => 'superadmin@videosapp.com',
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('123456789'),
            'super_admin' => true,
        ]);

        self::createTeamForUser($user);

        // 🔥 Crear permisos i assignar-los al rol super-admin
        VideoPermissionsHelper::createAndAssignVideoPermissions();

        // Assegurar que el rol superadmin existeix i assignar-lo
        $user->assignRole('super-admin');

        return $user;
    }

    /**
     * Crea un usuari regular.
     *
     * @return User
     */
    public static function createRegularUser(): User
    {
        $user = User::firstOrCreate([
            'email' => 'regular@videosapp.com',
        ], [
            'name' => 'Regular User',
            'password' => bcrypt('123456789'),
            'super_admin' => false,
        ]);

        self::createTeamForUser($user);

        if (!Role::where('name', 'regular-user')->exists()) {
            Role::create(['name' => 'regular-user']);
        }

        $user->assignRole('regular-user');

        return $user;
    }

    /**
     * Crea un usuari Video Manager.
     *
     * @return User
     */
    public static function createVideoManagerUser(): User
    {
        $user = User::firstOrCreate([
            'email' => 'videosmanager@videosapp.com',
        ], [
            'name' => 'Video Manager',
            'password' => bcrypt('123456789'),
            'super_admin' => false,
        ]);

        self::createTeamForUser($user);

        if (!Role::where('name', 'video-manager')->exists()) {
            Role::create(['name' => 'video-manager']);
        }

        $user->assignRole('video-manager');

        return $user;
    }

    /**
     * Crea un Team personal per a l'usuari.
     *
     * @param User $user
     * @return void
     */
    private static function createTeamForUser(User $user): void
    {
        $team = Team::firstOrCreate([
            'user_id' => $user->id,
            'personal_team' => true,
        ], [
            'name' => $user->name . "'s Team",
        ]);

        $user->ownedTeams()->save($team);
        $user->switchTeam($team);

        // 🔥 Evita duplicats: només afegeix si no hi és
        if (!$team->users->contains($user->id)) {
            $team->users()->attach($user->id, ['role' => 'owner']);
        }
    }
}
