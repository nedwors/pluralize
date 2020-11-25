<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;

class Container
{
    public function has($binding)
    {
        if ($this->serviceContainerHasBinding($binding)) {
            return true;
        }

        return false;
    }

    protected function serviceContainerHasBinding($binding)
    {
        return app()->has($binding);
    }

    public function get($binding, ...$params)
    {
        if ($this->serviceContainerHasBinding($binding)) {
            return $this->resolveServiceContainerBinding($binding, ...$params);
        }
    }

    protected function resolveBinding($binding, ...$params)
    {
        $concrete = app($binding);

        if ($concrete instanceof Closure) {
            return $concrete(...$params);
        }

        return $concrete;
    }

    protected function resolveServiceContainerBinding($binding, ...$params)
    {
        $concrete = app($binding);

        if ($concrete instanceof Closure) {
            return $concrete(...$params);
        }

        return $concrete;
    }
}