<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;

class Fallback
{
    protected Container $container;
    protected $fallback = null;
    protected $defaultFallback = 'pluralize.fallback';
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
        return $this->generate($pluralString);
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
        if ($this->container->has($this->fallback)) {
            return $this->container->get($this->fallback, $pluralString);
        }

        return $this->fallback;
    }

    protected function getDefault($pluralString)
    {
        if ($this->container->has($this->defaultFallback)) {
            return $this->container->get($this->defaultFallback, $pluralString);
        }

        return $this->baseFallback;
    }
}