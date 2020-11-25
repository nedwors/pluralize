<?php

namespace Nedwors\Pluralize\Pluralize\Utilities;

use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;

class Engine
{
    protected Counter $counter;
    protected Fallback $fallback;
    protected Output $output;

    public function counter(): Counter
    {
        return $this->counter ??= app(Counter::class);
    }

    public function output(): Output
    {
        return $this->output ??= app(Output::class);
    }

    public function fallback(): Fallback
    {
        return $this->fallback ??= app(Fallback::class);
    }
}