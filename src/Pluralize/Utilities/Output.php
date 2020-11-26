<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;
use Nedwors\Pluralize\Pluralize\Utilities\Container\Bindings;

class Output extends Vendor
{
    protected Bindings $bindings;
    protected Parser $parser;

    public function __construct(Bindings $bindings, Parser $parser)
    {
        $this->bindings = $bindings;
        $this->parser = $parser;
    }

    public function get($pluralString, $count, $singularString)
    {
        $result = $this->generate($singularString, $pluralString, $count);

        if (!$result) {
            $result = "$count $pluralString";
        }

        $result = $this->parser->run($result, $count);
        $this->userRequest = null;
        return $result;
    }
}