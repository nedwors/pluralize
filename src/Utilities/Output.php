<?php

namespace Nedwors\Pluralize\Utilities;

use Nedwors\Pluralize\Utilities\Container\Bindings;

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
        $result = $this->generate($singularString, $pluralString, $count)
                    ?? "$count $pluralString";

        return $this->parser->run($result, $count);
    }
}
