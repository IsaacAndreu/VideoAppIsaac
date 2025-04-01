<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersManageController;

Route::get('/', function () {
    return view('welcome');
});

// --- VÍDEOS PÚBLICS (només la pàgina d'índex) ---
Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');

// Rutes per veure vídeos (requereixen autenticació i permís 'view videos')
Route::middleware(['auth', 'can:view videos'])->group(function () {
    Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');
    Route::get('/videos/testedBy/{userId}', [VideosController::class, 'testedBy'])->name('videos.testedBy');
});

// --- USUARIS: índex i show (només per usuaris loguejats) ---
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Llistat d'usuaris
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    // Detall d'un usuari
    Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');

    // Dashboard també hi va aquí si vols
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// --- Rutes protegides per a la gestió de vídeos (només usuaris amb 'manage videos') ---
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'can:manage videos'
])->prefix('manage/videos')->name('videos.manage.')->group(function () {
    Route::get('/', [VideosController::class, 'manageIndex'])->name('index');
    Route::get('/create', [VideosController::class, 'create'])->name('create');
    Route::post('/', [VideosController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [VideosController::class, 'edit'])->name('edit');
    Route::put('/{id}', [VideosController::class, 'update'])->name('update');
    Route::delete('/{id}', [VideosController::class, 'destroy'])->name('destroy');
});

// --- Rutes protegides per a la gestió d'usuaris (només usuaris amb 'manage users') ---
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'can:manage users'
])->prefix('manage/users')->name('users.manage.')->group(function () {
    Route::get('/', [UsersManageController::class, 'index'])->name('index');
    Route::get('/create', [UsersManageController::class, 'create'])->name('create');
    Route::post('/', [UsersManageController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UsersManageController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UsersManageController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [UsersManageController::class, 'delete'])->name('delete');
    Route::delete('/{id}', [UsersManageController::class, 'destroy'])->name('destroy');
    // testedBy (si vols replicar la lògica de vídeos)
    Route::get('/{id}/testedBy', [UsersManageController::class, 'testedBy'])->name('testedBy');
});
