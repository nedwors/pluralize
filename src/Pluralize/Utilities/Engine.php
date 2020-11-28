<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;

class Engine
{
    protected Counter $counter;
    protected Fallback $fallback;
    protected Output $output;

    public function __construct(Counter $counter, Fallback $fallback, Output $output)
    {
        $this->counter = $counter;
        $this->fallback = $fallback;
        $this->output = $output;
    }

    public function counter(): Counter
    {
        return $this->counter;
    }

    public function output(): Output
    {
        return $this->output;
    }

    public function fallback(): Fallback
    {
        return $this->fallback;
    }

    public function pluralization($driver): Pluralization
    {
        return app($driver);
    }
}
