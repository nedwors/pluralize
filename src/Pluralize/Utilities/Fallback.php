<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Illuminate\Support\Collection;

class Fallback
{
    protected $fallback = '-';

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
            return $this->fallback;
        }

        if (is_callable($this->fallback)) {
            return call_user_func($this->fallback, $pluralString);
        }
    }
}