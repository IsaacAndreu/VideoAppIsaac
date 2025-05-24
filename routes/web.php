<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\VideosManageController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SeriesManageController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersManageController;

// ────── HOME ──────
Route::get('/', fn () => redirect()->route('videos.index'));

// ────── VÍDEOS (PÚBLICS I DETALL) ──────
Route::get('/videos', [VideosController::class, 'index'])->name('videos.index');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'can:view,video'])
    ->get('/videos/{video}', [VideosController::class, 'show'])->name('videos.show');

// ────── SÈRIES (PÚBLIQUES I DETALL) ──────
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'can:view,serie'])
    ->get('/series/{serie}', [SeriesController::class, 'show'])->name('series.show');

// ────── NOTIFICACIONS PUSH ──────
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->get('/notifications/push', fn () => view('notifications.push'))
    ->name('notifications.push');

// ────── USUARIS ──────
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
    });

// ────── GESTIÓ DE VÍDEOS ──────
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('manage/videos')->name('videos.manage.')->group(function () {
        Route::get('/', [VideosManageController::class, 'index'])->name('index');
        Route::get('create', [VideosManageController::class, 'create'])->name('create');
        Route::post('/', [VideosManageController::class, 'store'])->name('store');
        Route::get('{video}', [VideosManageController::class, 'show'])->name('show');
        Route::get('{video}/edit', [VideosManageController::class, 'edit'])->name('edit');
        Route::put('{video}', [VideosManageController::class, 'update'])->name('update');
        Route::get('{video}/delete', [VideosManageController::class, 'delete'])->name('delete');
        Route::delete('{video}', [VideosManageController::class, 'destroy'])->name('destroy');
        Route::get('testedby/{user}', [VideosManageController::class, 'testedBy'])->name('testedBy');
    });

// ────── GESTIÓ D’USUARIS ──────
Route::middleware([
    'auth:sanctum', config('jetstream.auth_session'), 'verified',
    'can:manage,App\Models\User',
])->prefix('manage/users')->name('users.manage.')->group(function () {
    Route::get('/', [UsersManageController::class, 'index'])->name('index');
    Route::get('create', [UsersManageController::class, 'create'])->name('create');
    Route::post('/', [UsersManageController::class, 'store'])->name('store');
    Route::get('{user}/edit', [UsersManageController::class, 'edit'])->name('edit');
    Route::put('{user}', [UsersManageController::class, 'update'])->name('update');
    Route::get('{user}/delete', [UsersManageController::class, 'delete'])->name('delete');
    Route::delete('{user}', [UsersManageController::class, 'destroy'])->name('destroy');
});

// ────── GESTIÓ DE SÈRIES ──────
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->prefix('manage/series')->name('series.manage.')->group(function () {
        Route::get('create', [SeriesManageController::class, 'create'])
            ->middleware('can:create,App\Models\Serie')->name('create');
        Route::post('/', [SeriesManageController::class, 'store'])
            ->middleware('can:create,App\Models\Serie')->name('store');
        Route::get('/', [SeriesManageController::class, 'index'])
            ->middleware('can:manage,App\Models\Serie')->name('index');
        Route::get('{serie}', [SeriesManageController::class, 'show'])
            ->middleware('can:manage,App\Models\Serie')->name('show');
        Route::get('{serie}/edit', [SeriesManageController::class, 'edit'])
            ->middleware('can:update,serie')->name('edit');
        Route::put('{serie}', [SeriesManageController::class, 'update'])
            ->middleware('can:update,serie')->name('update');
        Route::get('{serie}/delete', [SeriesManageController::class, 'delete'])
            ->middleware('can:delete,serie')->name('delete');
        Route::delete('{serie}', [SeriesManageController::class, 'destroy'])
            ->middleware('can:delete,serie')->name('destroy');
    });
