<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;
use Nedwors\Pluralize\Pluralize\Utilities\Container\Bindings;

class Fallback
{
    protected Bindings $bindings;
    protected $fallback = null;

    public function __construct(Bindings $bindings)
    {
        $this->bindings = $bindings;
    }

    public function set($fallback)
    {
        $this->fallback = $fallback ?? $this->fallback;
    }

    public function get($pluralString, $singularString)
    {
        $result = $this->generate($pluralString, $singularString);
        $this->fallback = null;
        return $result;
    }

    protected function generate($pluralString, $singularString)
    {
        if (is_callable($this->fallback)) {
            return call_user_func($this->fallback, $pluralString);
        }
        
        if (is_string($this->fallback)) {
            return $this->getFromString($pluralString);
        }

        return $this->getDefault($pluralString, $singularString);
    }

    protected function getFromString($pluralString)
    {
        if ($this->bindings->has($this->fallback)) {
            return $this->resolveBinding($this->fallback, $pluralString);
        }

        return $this->fallback;
    }

    protected function getDefault($pluralString, $singularString)
    {
        if ($this->bindings->has($singularString)) {
            return $this->resolveBinding($singularString, $pluralString);
        }

        if ($this->bindings->has(Bindings::DEFAULT)) {
            return $this->resolveBinding(Bindings::DEFAULT, $pluralString);
        }

        return '-';
    }

    protected function resolveBinding($binding, ...$params)
    {
        $concrete = $this->bindings->get($binding);

        if ($concrete instanceof Closure) {
            return call_user_func($concrete, ...$params);
        }

        return $concrete;
    }
}