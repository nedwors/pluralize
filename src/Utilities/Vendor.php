<?php

namespace Nedwors\Pluralize\Utilities;

use Nedwors\Pluralize\Utilities\Container\Bindings;

abstract class Vendor
{
    protected $userRequest = null;

    public function set($userRequest)
    {
        $this->userRequest = $userRequest ?? $this->userRequest;
    }

    protected function generate($singularString, ...$params)
    {
        return $this->getFromUserRequest(...$params) ?? $this->getDefault($singularString, ...$params);
    }

    protected function getFromUserRequest(...$params)
    {
        if (is_callable($this->userRequest)) {
            return $this->runClosure($this->userRequest, ...$params);
        }

        if (is_string($this->userRequest)) {
            return $this->getFromString(...$params);
        }
    }

    protected function getFromString(...$params)
    {
        return $this->canBeResolved($this->userRequest)
            ? $this->resolve($this->userRequest, ...$params)
            : $this->userRequest;
    }

    protected function getDefault($singularString, ...$params)
    {
        if ($this->canBeResolved($singularString)) {
            return $this->resolve($singularString, ...$params);
        }

        if ($this->canBeResolved(Bindings::DEFAULT)) {
            return $this->resolve(Bindings::DEFAULT, ...$params);
        }
    }

    protected function canBeResolved($binding)
    {
        return $this->bindings->has($binding);
    }

    protected function resolve($output, ...$params)
    {
        return is_callable($concrete = $this->bindings->get($output))
            ? $this->runClosure($concrete, ...$params)
            : $concrete;
    }

    protected function runClosure($closure, ...$params)
    {
        return call_user_func($closure, ...$params);
    }
}
