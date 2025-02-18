<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Team;
use Spatie\Permission\Models\Role;

class DefaultUsers
{
    /**
     * Crea un usuari per defecte.
     *
     * @return User
     */
    public static function crearUsuariPerDefecte(): User
    {
        User::where('email', config('default_users.user.email'))->delete();

        $password = config('default_users.user.password');
        if (!is_string($password)) {
            throw new \InvalidArgumentException('The default user password must be a string.');
        }

        $user = User::create([
            'name' => config('default_users.user.name'),
            'email' => config('default_users.user.email'),
            'password' => bcrypt($password),
        ]);

        self::addPersonalTeam($user);

        return $user;
    }

    /**
     * Crea un professor per defecte amb permisos de Super Admin.
     *
     * @return User
     */
    public static function crearProfessorPerDefecte(): User
    {
        User::where('email', config('default_users.professor.email'))->delete();

        $password = config('default_users.professor.password');
        if (!is_string($password)) {
            throw new \InvalidArgumentException('The default professor password must be a string.');
        }

        $professor = User::create([
            'name' => config('default_users.professor.name'),
            'email' => config('default_users.professor.email'),
            'password' => bcrypt($password),
            'super_admin' => true, // Ara és super admin
        ]);

        self::addPersonalTeam($professor);

        // **Assignar rol de Super Admin**
        $professor->assignRole('super-admin');

        return $professor;
    }

    /**
     * Afegir un equip personal a l'usuari.
     */
    private static function addPersonalTeam(User $user): void
    {
        $team = Team::create([
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        $user->teams()->attach($team->id, ['role' => 'owner']);
        $user->current_team_id = $team->id;
        $user->save();
    }

    /**
     * Crea un usuari normal.
     *
     * @return User
     */
    public static function createRegularUser(): User
    {
        $user = User::create([
            'name' => 'Regular',
            'email' => 'regular@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);

        // **Assignar rol de Regular User**
        $user->assignRole('regular-user');

        return $user;
    }

    /**
     * Crea un gestor de vídeos.
     *
     * @return User
     */
    public static function createVideoManagerUser(): User
    {
        $user = User::create([
            'name' => 'Video Manager',
            'email' => 'videosmanager@videosapp.com',
            'password' => bcrypt('123456789'),
        ]);

        // **Assignar rol de Video Manager**
        $user->assignRole('video-manager');

        return $user;
    }

    /**
     * Crea un superadmin.
     *
     * @return User
     */
    public static function createSuperAdminUser(): User
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@videosapp.com',
            'password' => bcrypt('123456789'),
            'super_admin' => true, // Assignat com superadmin
        ]);

        // **Assignar rol de Super Admin**
        $user->assignRole('super-admin');

        return $user;
    }
}
