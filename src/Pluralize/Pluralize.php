<?php

namespace Nedwors\Pluralize\Pluralize;

use Nedwors\Pluralize\Pluralize\Utilities\Container\Container;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Nedwors\Pluralize\Pluralize\Utilities\Engine;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Stringable;
use Closure;

class Pluralize implements Stringable
{
    protected $plurilizationDriver;
    protected Engine $engine;
    protected string $singular;

    public function __construct($driver)
    {
        $this->startEngine();
        $this->plurilizationDriver = $driver;
    }

    /**
     * Set the class name of the desired Pluralization driver.
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
     * Begin to bind into the engine's container.
     *
     * @param string $key
     * @return Container
     */
    public static function bind($key = null): Container
    {
        return app(Container::class)->bind($key);
    }

    /**
     * Define the singular form of the word to be pluralized.
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
     * Define what should be counted.
     *
     * @param int|array|Collection|LengthAwarePaginator|Paginator $countable
     * @return Pluralize
     */
    public function from($countable): self
    {
        $this->engine->counter()->calculate($countable);

        return $this;
    }

    /**
     * Define the format of the generated string.
     *
     * @param string|Closure $output
     * @return Pluralize
     */
    public function as($output): self
    {
        $this->engine->output()->set($output);

        return $this;
    }

    /**
     * Define the format of the generated fallback string.
     *
     * @param string|Closure $fallback
     * @return Pluralize
     */
    public function or($fallback): self
    {
        $this->engine->fallback()->set($fallback);

        return $this;
    }

    /**
     * Return the generated string.
     *
     * @return string
     */
    public function go()
    {
        $string = $this->countIsNull() ? $this->getFallback() : $this->getOutput();
        $this->startEngine();

        return $string;
    }

    protected function countIsNull()
    {
        return is_null($this->engine->counter()->count);
    }

    protected function getFallback()
    {
        return $this->engine->fallback()->get($this->pluralized(), $this->singular);
    }

    protected function getOutput()
    {
        return $this->engine->output()->get($this->pluralized(), $this->engine->counter()->count, $this->singular);
    }

    protected function pluralized()
    {
        return $this->engine->pluralization($this->plurilizationDriver)
                            ->run($this->singular, $this->engine->counter()->count);
    }

    protected function startEngine()
    {
        $this->engine = app(Engine::class);
    }

    public function __invoke()
    {
        return $this->go();
    }

    public function __toString()
    {
        return $this->go();
    }
}
