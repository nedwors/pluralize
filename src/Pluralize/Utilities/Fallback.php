<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;

class Fallback
{
    protected $fallback = '-';
    protected $defaultFallback = 'pluralize.fallback';

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
        if (is_string($this->fallback)) {
            return $this->getFromString($pluralString);
        }

        if (is_callable($this->fallback)) {
            return call_user_func($this->fallback, $pluralString);
        }
    }

    protected function getFromString($pluralString)
    {
        if (app()->has($this->fallback)) {
            return $this->resolveBinding($this->fallback, $pluralString);
        }

        if (app()->has($this->defaultFallback)) {
            return $this->resolveBinding($this->defaultFallback, $pluralString);
        }

        return $this->fallback;
    }

    protected function resolveBinding($fallback, $pluralString)
    {
        $concrete = app($fallback);

        if ($concrete instanceof Closure) {
            return $concrete($pluralString);
        }

        return $concrete;
    }
}