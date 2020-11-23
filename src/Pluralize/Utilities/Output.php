<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;

class Output
{
    protected $output = null;
    protected $defaultOutput = 'pluralize.output';
    protected Parser $parser;

    public function __construct(Parser $parser)
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
        if (is_callable($this->output)) {
            return $this->callOutput($pluralString, $count);
        }

        if (is_string($this->output)) {
            return $this->getFromString($pluralString, $count);
        }

        return $this->getDefault($pluralString, $count);
    }

    public function callOutput($pluralString, $count)
    {
        $string = call_user_func($this->output, $pluralString, $count);
        return $this->parser->run($string, $count);
    }

    protected function getFromString($pluralString, $count)
    {
        if (app()->has($this->output)) {
            return $this->resolveBinding($this->output, $pluralString, $count);
        }
    }

    protected function getDefault($pluralString, $count)
    {
        if (app()->has($this->defaultOutput)) {
            return $this->resolveBinding($this->defaultOutput, [$pluralString, $count]);
        }

        return "$count $pluralString";
    }

    protected function resolveBinding($output, $params)
    {
        $concrete = app($output);

        if ($concrete instanceof Closure) {
            return $concrete(...$params);
        }

        return $concrete;
    }
}