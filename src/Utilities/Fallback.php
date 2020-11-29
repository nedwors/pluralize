<?php

namespace Nedwors\Pluralize\Utilities;

use Nedwors\Pluralize\Utilities\Container\Bindings;

class Fallback extends Vendor
{
    protected Bindings $bindings;

    public function __construct(Bindings $bindings)
    {
        $this->bindings = $bindings;
    }

    public function get($pluralString, $singularString)
    {
        return $this->generate($singularString, $pluralString) ?? '-';
    }
}
