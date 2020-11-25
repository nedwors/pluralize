<?php

namespace Nedwors\Pluralize;    

use Illuminate\Support\ServiceProvider;
use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;
use Nedwors\Pluralize\Pluralize\Utilities\Pluralization\LaravelStrEngine;

class PluralizeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'pluralize');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'pluralize');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        include_once __DIR__ . "/helpers.php";

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/pluralize.php' => config_path('pluralize.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/pluralize'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/pluralize'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/pluralize'),
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
        $this->mergeConfigFrom(__DIR__.'/../config/pluralize.php', 'pluralize');

        $this->bindPluralizationEngine();
    }

    protected function bindPluralizationEngine()
    {
        $engine = data_get(config('pluralize.drivers'), 'pluralization', LaravelStrEngine::class);

        $this->app->bind(Pluralization::class, $engine);
    }
}
