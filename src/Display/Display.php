<?php

namespace Nedwors\Pluralize\Display;

class Display
{
    protected ?string $item;

    public static function this(?string $item): self
    {
        $instance = app(self::class);
        $instance->item = $item;

        return $instance;
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
        return is_null($this->item) ? $this->getFallback() : $this->getOutput();
    }

    protected function getFallback()
    {
        return '-';
    }

    protected function getOutput()
    {
        return $this->item;
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