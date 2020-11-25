<?php

namespace Nedwors\Pluralize\Pluralize\Utilities\Pluralization;

use Illuminate\Support\Str;
use Nedwors\Pluralize\Pluralize\Contracts\PluralizationEngine;

class LaravelStrEngine implements PluralizationEngine
{
    public function run(string $string, $count): string
    {
        return Str::plural($string, $count);
    }
}