<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Closure;

class Output
{
    protected Container $container;
    protected $output = null;
    protected $defaultOutput = 'default';
    protected Parser $parser;

    public function __construct(Container $container, Parser $parser)
    {
        $this->parser = $parser;
        $this->container = $container;
    }

    public function set($output)
    {
        $this->output = $output ?? $this->output;
    }

    public function get($pluralString, $count)
    {
        $result = $this->generate($pluralString, $count);
        $this->output = null;
        return $result;
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
            return $this->resolveBinding($this->output, [$pluralString, $count]);
        }
    }

    protected function getDefault($pluralString, $count)
    {
        if ($this->container->hasOutput($this->defaultOutput)) {
            return $this->resolveBinding($this->defaultOutput, [$pluralString, $count]);
        }

        return "$count $pluralString";
    }

    protected function resolveBinding($output, $params)
    {
        $concrete = $this->container->getOutput($output);

        if ($concrete instanceof Closure) {
            return $concrete(...$params);
        }

        return $concrete;
    }
}