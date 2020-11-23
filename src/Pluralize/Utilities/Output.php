<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;

class Output
{
    protected ?Closure $output = null;
    protected OutputParser $parser;

    public function __construct(OutputParser $parser)
    {
        $this->parser = $parser;
    }

    public function set($output)
    {
        $this->output = $output ?? $this->output;
    }

    public function get($pluralString, $count)
    {
        return $this->generate($pluralString, $count);
    }

    protected function generate($pluralString, $count)
    {
        return $this->output
                ? $this->callOutput($pluralString, $count)
                : "$count $pluralString";
    }

    public function callOutput($pluralString, $count)
    {
        $string = call_user_func($this->output, $pluralString, $count);
        return $this->parser->run($string, $count);
    }
}