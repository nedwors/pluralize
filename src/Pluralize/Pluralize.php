<?php

namespace Nedwors\Pluralize\Pluralize;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nedwors\Pluralize\Pluralize\Utilities\Counter;
use Nedwors\Pluralize\Pluralize\Utilities\Fallback;
use Nedwors\Pluralize\Pluralize\Utilities\Output;

class Pluralize
{
    protected Counter $counter;
    protected Fallback $fallback;
    protected Output $output;
    protected string $item;
    protected ?int $count;
    
    public function __construct(Counter $counter, Fallback $fallback, Output $output)
    {
        $this->counter = $counter;
        $this->fallback = $fallback;
        $this->output = $output;
    }

    public function this(string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function from($countable): self
    {
        $this->count = $this->counter->calculate($countable);

        return $this;
    }

    public function as($as): self
    {
        $this->output->set($as);

        return $this;
    }

    public function or($fallback): self
    {
        $this->fallback->set($fallback);

        return $this;
    }

    protected function generate()
    {
        return is_null($this->count) ? $this->getFallback() : $this->getOutput();
    }

    protected function getFallback()
    {
        return $this->fallback->get($this->getPluralForm());
    }

    protected function getOutput()
    {
        return $this->output->get($this->getPluralForm(), $this->count);
    }

    protected function getPluralForm()
    {
        return Str::plural($this->item, $this->count);
    }

    public function __invoke()
    {
        return $this->generate();
    }

    public function __toString()
    {
        return $this->generate();
    }
}