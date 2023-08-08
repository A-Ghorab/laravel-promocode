<?php

namespace AGhorab\LaravelPromocode;

use Illuminate\Support\ServiceProvider;

class PromocodesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/promocodes.php' => config_path('promocodes.php'),
            ], 'config');

            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/promocodes.php', 'promocodes');
    }
}
