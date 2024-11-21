<?php

use App\Models\User;

if (!function_exists('crearUsuariPerDefecte')) {
    function crearUsuariPerDefecte()
    {
        return User::create([
            'name' => config('default_users.user.name'),
            'email' => config('default_users.user.email'),
            'password' => bcrypt(config('default_users.user.password')),
        ]);
    }
}

if (!function_exists('crearProfessorPerDefecte')) {
    function crearProfessorPerDefecte()
    {
        return User::create([
            'name' => config('default_users.professor.name'),
            'email' => config('default_users.professor.email'),
            'password' => bcrypt(config('default_users.professor.password')),
        ]);
    }
}
