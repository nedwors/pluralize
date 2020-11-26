<?php

namespace Nedwors\Pluralize\Pluralize;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Nedwors\Pluralize\Pluralize\Utilities\Engine;
use Nedwors\Pluralize\Pluralize\Utilities\Container\Container;
use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** @package Nedwors\Pluralize\Pluralize */
class Pluralize
{
    protected $plurilizationDriver;
    protected Engine $engine;
    protected string $item;
    protected ?int $count = null;
    
    public function __construct(Engine $engine, $driver)
    {
        $this->engine = $engine;
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
    public static function this(string $item): self
    {
        $instance = app(self::class);
        $instance->item = $item;

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
        return is_null($this->count) ? $this->getFallback() : $this->getOutput();
    }

    protected function getFallback()
    {
        return $this->engine->fallback()->get($this->getPluralForm(), $this->item);
    }

    protected function getOutput()
    {
        return $this->engine->output()->get($this->getPluralForm(), $this->count, $this->item);
    }

    protected function getPluralForm()
    {
        return $this->pluralization()->run($this->item, $this->count);
    }

    protected function pluralization(): Pluralization
    {
        return app($this->plurilizationDriver);
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