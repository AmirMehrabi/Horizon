<?php

namespace App\Providers;

use App\Services\OpenStack\OpenStackConnectionService;
use App\Services\OpenStack\OpenStackInstanceService;
use App\Services\OpenStack\OpenStackSyncService;
use App\Services\Sms\SmsService;
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

        // Register OpenStack Instance Service
        $this->app->bind(OpenStackInstanceService::class, function ($app) {
            return new OpenStackInstanceService(
                $app->make(OpenStackConnectionService::class)
            );
        });

        // Register OpenStack Sync Service
        $this->app->bind(OpenStackSyncService::class, function ($app) {
            return new OpenStackSyncService(
                $app->make(OpenStackConnectionService::class)
            );
        });

        // Register SMS Service as singleton
        $this->app->singleton(SmsService::class, function ($app) {
            return new SmsService();
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
