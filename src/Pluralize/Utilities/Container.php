<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Illuminate\Support\Arr;

class Container
{
    protected $outputs = [];
    protected $fallbacks = [];
    protected $key = null;

    public function bind($key = 'default'): self
    {
        $this->key = $key;

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