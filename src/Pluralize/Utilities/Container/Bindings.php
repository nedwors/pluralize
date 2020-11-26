<?php

namespace Nedwors\Pluralize\Pluralize\Utilities\Container;

interface Bindings
{
    const DEFAULT = 'pluralize-default-binding-key';
    
    public function set($key, $binding);
    public function get($key);
    public function has($key): bool;
}