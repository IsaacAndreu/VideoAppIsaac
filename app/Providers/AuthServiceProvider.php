<?php

namespace App\Providers;

use App\Models\Video;
use App\Models\Serie;
use App\Models\User;
use App\Policies\VideoPolicy;
use App\Policies\SeriesPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Video::class => VideoPolicy::class,
        Serie::class => SeriesPolicy::class,
        User::class  => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
