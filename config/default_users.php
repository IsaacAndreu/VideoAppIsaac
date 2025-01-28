<?php

return [
    'user' => [
        'name' => env('DEFAULT_USER_NAME', 'Usuari Defecte'),
        'email' => env('DEFAULT_USER_EMAIL', 'usuari@example.com'),
        'password' => env('DEFAULT_USER_PASSWORD', 'password123'),
        'team' => env('DEFAULT_USER_TEAM', "Usuari Defecte's Team"),
    ],
    'professor' => [
        'name' => env('DEFAULT_PROFESSOR_NAME', 'Professor Defecte'),
        'email' => env('DEFAULT_PROFESSOR_EMAIL', 'professor@example.com'),
        'password' => env('DEFAULT_PROFESSOR_PASSWORD', 'password456'),
        'team' => env('DEFAULT_PROFESSOR_TEAM', "Professor Defecte's Team"),
    ],
];

