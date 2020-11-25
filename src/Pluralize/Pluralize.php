<?php

namespace Nedwors\Pluralize\Pluralize;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Nedwors\Pluralize\Pluralize\Utilities\Engine;
use Nedwors\Pluralize\Pluralize\Utilities\Container;
use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Nedwors\Pluralize\Pluralize\Utilities\Pluralization\LaravelStrPluralization;

/** @package Nedwors\Pluralize\Pluralize */
class Pluralize
{
    protected $plurilizationDriver = LaravelStrPluralization::class;
    protected Engine $engine;
    protected string $item;
    protected ?int $count = null;
    
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public static function driver($driver): self
    {
        $instance = app(self::class);
        $instance->plurilizationDriver = $driver;

        return $instance;
    }

    public static function bind($key = 'default'): Container
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
        return $this->engine->fallback()->get($this->getPluralForm());
    }

    protected function getOutput()
    {
        return $this->engine->output()->get($this->getPluralForm(), $this->count);
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