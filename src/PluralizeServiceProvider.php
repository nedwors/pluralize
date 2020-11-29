<?php

namespace Nedwors\Pluralize;

use Illuminate\Support\ServiceProvider;
use Nedwors\Pluralize\Utilities\Container\ArrayBindings;
use Nedwors\Pluralize\Utilities\Container\Bindings;
use Nedwors\Pluralize\Utilities\Container\Container;
use Nedwors\Pluralize\Utilities\Fallback;
use Nedwors\Pluralize\Utilities\Output;
use Nedwors\Pluralize\Utilities\Parser;
use Nedwors\Pluralize\Utilities\Pluralization\LaravelStrPluralization;

class PluralizeServiceProvider extends ServiceProvider
{
    public $bindings = [
        Bindings::class => ArrayBindings::class,
    ];

    public function boot()
    {
        include_once __DIR__.'/helpers.php';
    }

    public function register()
    {
        $this->app->singleton(Container::class, fn () => new Container(app(Bindings::class), app(Bindings::class)));
        $this->app->singleton(Pluralize::class, fn () => new Pluralize(LaravelStrPluralization::class));

        $this->app->bind(Output::class, fn () => new Output(app(Container::class)->outputs, app(Parser::class)));
        $this->app->bind(Fallback::class, fn () => new Fallback(app(Container::class)->fallbacks));
    }
}
