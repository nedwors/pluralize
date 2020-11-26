<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Illuminate\Support\Arr;

class Container
{
    const DEFAULT_BINDING = 'pluralize-default-binding-key';
    protected $outputs = [];
    protected $fallbacks = [];
    protected $key = null;

    public function bind($key = null): self
    {
        $this->key = $key ?? self::DEFAULT_BINDING;

        return $this;
    }

    public function output($binding): self
    {
        $this->outputs[$this->key] = $binding;

        return $this;
    }

    public function fallback($binding): self
    {
        $this->fallbacks[$this->key] = $binding;

        return $this;
    }

    public function hasOutput($key)
    {
        return Arr::exists($this->outputs, $key);
    }

    public function getOutput($key)
    {
        return data_get($this->outputs, $key);
    }

    public function hasFallback($key)
    {
        return Arr::exists($this->fallbacks, $key);
    }

    public function getFallback($key)
    {
        return data_get($this->fallbacks, $key);
    }
}