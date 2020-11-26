<?php

namespace Nedwors\Pluralize\Pluralize\Utilities\Container;

use Illuminate\Support\Arr;

class ArrayBindings implements Bindings
{
    protected $bindings = [];
    
    public function set($key, $binding)
    {
        $this->bindings[$key] = $binding;
    }

    public function get($key)
    {
        return data_get($this->bindings, $key);
    }

    public function has($key): bool
    {
        return Arr::exists($this->bindings, $key);
    }
}