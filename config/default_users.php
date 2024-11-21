<?php

return [
    'user' => [
        'name' => env('DEFAULT_USER_NAME', 'Usuari Defecte'),
        'email' => env('DEFAULT_USER_EMAIL', 'usuari@example.com'),
        'password' => env('DEFAULT_USER_PASSWORD', 'password123'),
    ],
    'professor' => [
        'name' => env('DEFAULT_PROFESSOR_NAME', 'Professor Defecte'),
        'email' => env('DEFAULT_PROFESSOR_EMAIL', 'professor@example.com'),
        'password' => env('DEFAULT_PROFESSOR_PASSWORD', 'password456'),
    ],
];
