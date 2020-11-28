<?php

namespace Nedwors\Pluralize\Pluralize\Utilities\Container;

class Container
{
    public Bindings $outputs;
    public Bindings $fallbacks;
    protected $key = null;

    public function __construct(Bindings $outputs, Bindings $fallbacks)
    {
        $this->outputs = $outputs;
        $this->fallbacks = $fallbacks;
    }

    public function bind($key = null): self
    {
        $this->key = $key ?? Bindings::DEFAULT;

        return $this;
    }

    public function output($binding): self
    {
        $this->outputs->set($this->key, $binding);

        return $this;
    }

    public function fallback($binding): self
    {
        $this->fallbacks->set($this->key, $binding);

        return $this;
    }
}
