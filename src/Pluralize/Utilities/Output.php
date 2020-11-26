<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;
use Nedwors\Pluralize\Pluralize\Utilities\Container\Bindings;

class Output
{
    protected Bindings $bindings;
    protected Parser $parser;
    protected $output = null;

    public function __construct(Bindings $bindings, Parser $parser)
    {
        $this->parser = $parser;
        $this->bindings = $bindings;
    }

    public function set($output)
    {
        $this->output = $output ?? $this->output;
    }

    public function get($pluralString, $count, $singularString)
    {
        $result = $this->generate($pluralString, $count, $singularString);

        if ($result) {
            $result = $this->parser->run($result, $count);
        }

        $this->output = null;
        return $result;
    }

    protected function generate($pluralString, $count, $singularString)
    {
        if (is_callable($this->output)) {
            return call_user_func($this->output, $pluralString, $count);
        }

        if (is_string($this->output)) {
            return $this->getFromString($pluralString, $count);
        }

        return $this->getDefault($pluralString, $count, $singularString);
    }

    protected function getFromString($pluralString, $count)
    {
        if ($this->bindings->has($this->output)) {
            return $this->resolveBinding($this->output, $pluralString, $count);
        }

        return $this->output;
    }

    protected function getDefault($pluralString, $count, $singularString)
    {
        if ($this->bindings->has($singularString)) {
            return $this->resolveBinding($singularString, $pluralString, $count);
        }

        if ($this->bindings->has(Bindings::DEFAULT)) {
            return $this->resolveBinding(Bindings::DEFAULT, $pluralString, $count);
        }

        return "$count $pluralString";
    }

    protected function resolveBinding($output, ...$params)
    {
        $concrete = $this->bindings->get($output);

        if ($concrete instanceof Closure) {
            return $concrete(...$params);
        }

        return $concrete;
    }
}