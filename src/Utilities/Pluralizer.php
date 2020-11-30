<?php

namespace Nedwors\Pluralize\Utilities;

use Stringable;

class Pluralizer implements Stringable
{
    protected Engine $engine;
    protected string $singular;
    protected $pluralizationDriver;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public static function pluralize(string $singular): self
    {
        $instance = app(self::class);
        $instance->singular = $singular;

        return $instance;
    }

    public function using($pluralizationDriver): self
    {
        $this->pluralizationDriver = $pluralizationDriver;
        return $this;
    }

    /**
     * Define what should be counted.
     *
     * @param int|array|Collection|LengthAwarePaginator|Paginator $countable
     * @return Pluralizer
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
     * @return Pluralizer
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
     * @return Pluralizer
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
        return $this->countIsNull() ? $this->getFallback() : $this->getOutput();
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
        return $this->engine->pluralization($this->pluralizationDriver)
                            ->run($this->singular, $this->engine->counter()->count);
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