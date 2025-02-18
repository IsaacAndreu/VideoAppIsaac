<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\View\Components\VideosAppLayout;
use App\Models\User;
use App\Models\Video;
use App\Policies\VideoPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra qualsevol servei de l'aplicació.
     */
    public function register(): void
    {
        // Aquí es poden registrar serveis addicionals si calen.
    }

    /**
     * Inicia els serveis de l'aplicació.
     */
    public function boot(): void
    {
        // Comprovar si la classe VideosAppLayout existeix abans de registrar-la.
        if (class_exists(VideosAppLayout::class)) {
            Blade::component('videos-app-layout', VideosAppLayout::class);
        } else {
            \Log::warning('El component VideosAppLayout no existeix. Comprova la seva ubicació.');
        }

        // Registre de polítiques d'autorització
        Gate::policy(Video::class, VideoPolicy::class);

        // Definir les portes d'accés (Gates)
        Gate::before(function (?User $user, string $ability) {
            if (!$user) return null;
            return $user->hasRole('super-admin') ? true : null;
        });

        Gate::define('manage-videos', function (User $user) {
            return $user->hasAnyRole(['video-manager', 'super-admin']);
        });

        Gate::define('manage-users', function (User $user) {
            return $user->hasRole('super-admin'); // Eliminat 'admin' perquè no existeix
        });

        Gate::define('view-dashboard', function (User $user) {
            return $user->hasAnyRole(['video-manager', 'super-admin', 'regular-user']);
        });
    }
}
