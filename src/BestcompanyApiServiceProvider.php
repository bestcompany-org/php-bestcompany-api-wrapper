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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bestcompany-api');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'bestcompany-api');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/bcapi.php' => config_path('bestcompany-api.php'),
            ]);

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/bestcompany-api'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/bestcompany-api'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/bestcompany-api'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/bcapi.php', 'bestcompany-api');

        // Register the main class to use with the facade
        $this->app->singleton('bestcompany-api', function () {
            return BestcompanyApi::create([
              'key' => env('BC_API_KEY', config('bestcompany-api.api_key')),
              'hostname' => env('BC_HOSTNAME', config('bestcompany-api.hostname')),
              'version' => env('BC_API_VERSION', config('bestcompany-api.version')),
            ]);
        });
    }
}
