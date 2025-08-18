<?php

namespace Bestcompany\BestcompanyApi;

use Illuminate\Support\ServiceProvider;

class BestcompanyApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/bcapi.php' => config_path('bestcompany-api.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../config/snoball.php' => config_path('snoball.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/bcapi.php', 'bestcompany-api');
        $this->mergeConfigFrom(__DIR__.'/../config/snoball.php', 'snoball');

        // Register the main Bestcompany API client
        $this->app->singleton(BestcompanyApi::class, function () {
            return BestcompanyApi::create([
                'key' => config('bestcompany-api.api_key'),
                'hostname' => config('bestcompany-api.hostname'),
                'version' => config('bestcompany-api.version'),
            ]);
        });

        // Register the Snoball API client for referral requests
        $this->app->singleton(SnoballApi::class, function () {
            return SnoballApi::create([
                'key' => config('snoball.api_key'),
                'hostname' => config('snoball.hostname'),
                'version' => config('snoball.version'),
            ]);
        });
    }
}
