<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutes per al VideosController
    Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');
    Route::get('/videos/testedBy/{userId}', [VideosController::class, 'testedBy'])->name('videos.testedBy');
    Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');
});

