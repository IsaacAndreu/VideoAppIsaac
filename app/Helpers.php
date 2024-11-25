<?php

use App\Models\User;
use App\Models\Team;

if (!function_exists('crearUsuariPerDefecte')) {
    function crearUsuariPerDefecte()
    {
        User::where('email', config('default_users.user.email'))->delete();

        $user = User::create([
            'name' => config('default_users.user.name'),
            'email' => config('default_users.user.email'),
            'password' => bcrypt(config('default_users.user.password')),
        ]);

        $user->refresh();

        $team = Team::create([
            'name' => $user->name . "'s Team",
            'user_id' => $user->id,
            'personal_team' => true,
        ]);

        $user->teams()->attach($team->id, ['role' => 'owner']);

        return $user;
    }


}

if (!function_exists('crearProfessorPerDefecte')) {
    function crearProfessorPerDefecte()
    {
        $existingProfessor = User::where('email', config('default_users.professor.email'))->first();
        if ($existingProfessor) {
            $existingProfessor->delete();
        }

        $professor = User::create([
            'name' => config('default_users.professor.name'),
            'email' => config('default_users.professor.email'),
            'password' => bcrypt(config('default_users.professor.password')),
        ]);

        $professor->refresh();

        $team = Team::create([
            'name' => $professor->name . "'s Team",
            'user_id' => $professor->id,
            'personal_team' => true,
        ]);

        $professor->teams()->attach($team->id, ['role' => 'owner']);

        return $professor;
    }


}
