<?php

namespace Nedwors\Pluralize\Pluralize\Utilities\Pluralization;

use Illuminate\Support\Str;
use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;

class LaravelStrEngine implements Pluralization
{
    public function run(string $string, $count): string
    {
        return Str::plural($string, $count);
    }
}