<?php

namespace Nedwors\Pluralize\Pluralize;

use Nedwors\Pluralize\Pluralize\Utilities\Container\Container;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;
use Nedwors\Pluralize\Pluralize\Utilities\Engine;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Closure;

/** @package Nedwors\Pluralize\Pluralize */
class Pluralize
{
    protected $plurilizationDriver;
    protected Engine $engine;
    protected string $singular;
    protected ?int $count = null;
    
    public function __construct($driver)
    {
        $this->restartEngine();
        $this->plurilizationDriver = $driver;
    }

    /**
     * Set the class name of the desired Pluralization driver
     * 
     * @param string $driver 
     * @return Pluralize 
     */
    public static function driver($driver): self
    {
        $instance = app(self::class);
        $instance->plurilizationDriver = $driver;

        return $instance;
    }

    /**
     * Begin to bind into the engine's container
     * 
     * @param string $key 
     * @return Container 
     */
    public static function bind($key = null): Container
    {
        return app(Container::class)->bind($key);
    }

    /**
     * Define the singular form of the word to be pluralized
     * 
     * @param string $item 
     * @return Pluralize 
     */
    public static function this(string $singular): self
    {
        $instance = app(self::class);
        $instance->singular = $singular;

        return $instance;
    }

    /**
     * Define what should be counted
     * 
     * @param int|array|Collection|LengthAwarePaginator|Paginator $countable 
     * @return Pluralize 
     */
    public function from($countable): self
    {
        $this->count = $this->engine->counter()->calculate($countable);

        return $this;
    }

    /**
     * Define the format of the generated string
     * 
     * @param string|Closure $as 
     * @return Pluralize 
     */
    public function as($as): self
    {
        $this->engine->output()->set($as);

        return $this;
    }

    /**
     * Define the format of the generated fallback string
     * 
     * @param string|Closure $fallback 
     * @return Pluralize 
     */
    public function or($fallback): self
    {
        $this->engine->fallback()->set($fallback);

        return $this;
    }

    protected function generate()
    {
        $string = is_null($this->count) ? $this->getFallback() : $this->getOutput();
        $this->restartEngine();
        return $string;
    }

    protected function getFallback()
    {
        return $this->engine->fallback()->get($this->getPluralForm(), $this->singular);
    }

    protected function getOutput()
    {
        return $this->engine->output()->get($this->getPluralForm(), $this->count, $this->singular);
    }

    protected function getPluralForm()
    {
        return $this->pluralization()->run($this->singular, $this->count);
    }

    protected function pluralization(): Pluralization
    {
        return app($this->plurilizationDriver);
    }

    protected function restartEngine()
    {
        $this->engine = app(Engine::class);
    }

    public function __invoke()
    {
        return $this->generate();
    }

    public function __toString()
    {
        return $this->generate();
    }
}