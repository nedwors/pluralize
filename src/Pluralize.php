<?php

namespace Nedwors\Pluralize;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class Pluralize
{
    protected string $item;
    protected ?int $count;
    protected ?Closure $output = null;
    protected $fallback = '-';

    public function this(string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function from($countable): self
    {
        $this->count = $this->getCount($countable);

        return $this;
    }

    public function as($as): self
    {
        $this->output = $as ?? $this->output;

        return $this;
    }

    public function or($fallback): self
    {
        $this->fallback = $fallback ?? $this->fallback;

        return $this;
    }

    protected function getCount($countable)
    {
        if (is_integer($countable)) {
            return $countable;
        }

        if (is_array($countable)) {
            return count($countable);
        }

        if ($countable instanceof Collection) {
            return $countable->count();
        }
    }

    protected function generate()
    {
        return is_null($this->count) ? $this->getFallback() : $this->getOutput();
    }

    protected function getFallback()
    {
        if (is_string($this->fallback)) {
            return $this->fallback;
        }

        if (is_callable($this->fallback)) {
            return call_user_func($this->fallback, $this->getPluralForm());
        }
    }

    protected function getOutput()
    {
        return $this->output
            ? call_user_func($this->output, $this->getPluralForm(), $this->count)
            : "{$this->count} {$this->getPluralForm()}";
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
