<?php

namespace Nedwors\Pluralize;

use Nedwors\Pluralize\Utilities\Container\Container;
use Nedwors\Pluralize\Utilities\Pluralizer;

class Pluralize
{
    protected $pluralizationDriver;

    public function __construct($driver)
    {
        $this->pluralizationDriver = $driver;
    }

    /**
     * Set the class name of the desired Pluralization driver.
     *
     * @param  string  $driver
     */
    public static function driver($driver): self
    {
        $instance = app(self::class);
        $instance->pluralizationDriver = $driver;

        return $instance;
    }

    /**
     * Begin to bind into the engine's container.
     *
     * @param  string  $key
     */
    public static function bind($key = null): Container
    {
        return app(Container::class)->bind($key);
    }

    /**
     * Define the singular form of the word to be pluralized.
     *
     * @param  string  $item
     */
    public static function this(string $singular): Pluralizer
    {
        return Pluralizer::pluralize($singular)->using(app(self::class)->pluralizationDriver);
    }
}
