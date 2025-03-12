<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;

Route::get('/', function () {
    return view('welcome');
});

// Rutes públiques (accessible per a tothom)
Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');

// Rutes per veure vídeos (requereixen autenticació i permís de "view videos")
Route::middleware(['auth', 'can:view videos'])->group(function () {
    Route::get('/videos/{id}', [VideosController::class, 'show'])->name('videos.show');
    Route::get('/videos/testedBy/{userId}', [VideosController::class, 'testedBy'])->name('videos.testedBy');
});

// Rutes protegides per la gestió de vídeos (només per usuaris amb el permís "manage videos")
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'can:manage videos'
])->group(function () {
    // Ruta per al dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutes del CRUD de vídeos amb el prefix "manage/videos"
    Route::prefix('manage/videos')->name('videos.manage.')->group(function () {
        Route::get('/', [VideosController::class, 'manageIndex'])->name('index');
        Route::get('/create', [VideosController::class, 'create'])->name('create');
        Route::post('/', [VideosController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [VideosController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VideosController::class, 'update'])->name('update');
        Route::delete('/{id}', [VideosController::class, 'destroy'])->name('destroy');
    });
});
