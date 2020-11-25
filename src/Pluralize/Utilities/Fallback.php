<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;

class Fallback
{
    protected Container $container;
    protected $fallback = null;
    protected $defaultFallback = 'default';
    protected $baseFallback = '-';

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function set($fallback)
    {
        $this->fallback = $fallback ?? $this->fallback;
    }

    public function get($pluralString)
    {
        $result = $this->generate($pluralString);
        $this->fallback = null;
        return $result;
    }

    protected function generate($pluralString)
    {
        if (is_callable($this->fallback)) {
            return call_user_func($this->fallback, $pluralString);
        }
        
        if (is_string($this->fallback)) {
            return $this->getFromString($pluralString);
        }

        return $this->getDefault($pluralString);
    }

    protected function getFromString($pluralString)
    {
        if ($this->container->hasFallback($this->fallback)) {
            return $this->resolveBinding($this->fallback, $pluralString);
        }

        return $this->fallback;
    }

    protected function getDefault($pluralString)
    {
        if ($this->container->hasFallback($this->defaultFallback)) {
            return $this->resolveBinding($this->defaultFallback, $pluralString);
            
        }

        return $this->baseFallback;
    }

    protected function resolveBinding($binding, ...$params)
    {
        $concrete = $this->container->getFallback($binding);

        if ($concrete instanceof Closure) {
            return $concrete(...$params);
        }

        return $concrete;
    }
}