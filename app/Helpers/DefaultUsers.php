<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Team;

class DefaultUsers
{
    /**
     * Crea un usuari per defecte.
     *
     * @return User
     */
    public static function crearUsuariPerDefecte(): User
    {
        // Eliminar l'usuari si ja existeix
        User::where('email', config('default_users.user.email'))->delete();

        // Validar que la contrasenya és una cadena
        $password = config('default_users.user.password');
        if (!is_string($password)) {
            throw new \InvalidArgumentException('The default user password must be a string.');
        }

        // Crear l'usuari
        $user = User::create([
            'name' => config('default_users.user.name'),
            'email' => config('default_users.user.email'),
            'password' => bcrypt($password),
        ]);

        // Crear l'equip associat a l'usuari
        $team = Team::create([
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        $user->teams()->attach($team->id, ['role' => 'owner']);
        $user->current_team_id = $team->id;
        $user->save();

        return $user;
    }

    /**
     * Crea un professor per defecte.
     *
     * @return User
     */
    public static function crearProfessorPerDefecte(): User
    {
        // Eliminar el professor si ja existeix
        User::where('email', config('default_users.professor.email'))->delete();

        // Validar que la contrasenya és una cadena
        $password = config('default_users.professor.password');
        if (!is_string($password)) {
            throw new \InvalidArgumentException('The default professor password must be a string.');
        }

        // Crear el professor
        $professor = User::create([
            'name' => config('default_users.professor.name'),
            'email' => config('default_users.professor.email'),
            'password' => bcrypt($password),
        ]);

        // Crear l'equip associat al professor
        $team = Team::create([
            'name' => $professor->name . "'s Team",
            'user_id' => $professor->id,
            'personal_team' => true,
        ]);

        $professor->teams()->attach($team->id, ['role' => 'owner']);
        $professor->current_team_id = $team->id;
        $professor->save();

        return $professor;
    }
}
