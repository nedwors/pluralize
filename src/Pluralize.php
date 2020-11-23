<?php

namespace Nedwors\Pluralize;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class Pluralize
{
    protected string $item;
    protected ?int $count;
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

    public function or($fallback)
    {
        $this->fallback = $fallback;

        return $this->generate();
    }

    protected function generate()
    {
        return is_null($this->count) ? $this->fallback() : $this->output();
    }

    protected function fallback()
    {
        if (is_string($this->fallback)) {
            return $this->fallback;
        }

        if (is_callable($this->fallback)) {
            $fallback = $this->fallback;
            return $fallback($this->getPluralForm());
        }
    }

    protected function output()
    {
        return $this->count . ' ' . $this->getPluralForm();
    }

    protected function getPluralForm()
    {
        return Str::plural($this->item, $this->count);
    }

    public function __invoke()
    {
        return $this->generate();
    }
}
