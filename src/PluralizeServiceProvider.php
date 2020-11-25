<?php

namespace Nedwors\Pluralize;    

use Illuminate\Support\ServiceProvider;
use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;
use Nedwors\Pluralize\Pluralize\Pluralize;
use Nedwors\Pluralize\Pluralize\Utilities\Container;
use Nedwors\Pluralize\Pluralize\Utilities\Engine;
use Nedwors\Pluralize\Pluralize\Utilities\Pluralization\LaravelStrPluralization;

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

        $this->app->singleton(Pluralize::class, fn() => new Pluralize(app(Engine::class)));
        $this->app->singleton(Container::class, fn() => new Container());
    }
}