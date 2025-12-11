<?php

namespace App\Providers;

use App\Services\OpenStack\OpenStackConnectionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register OpenStack Connection Service as singleton
        $this->app->singleton(OpenStackConnectionService::class, function ($app) {
            return new OpenStackConnectionService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
