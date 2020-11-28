<?php

namespace Nedwors\Pluralize\Pluralize\Utilities\Pluralization;

use Nedwors\Pluralize\Pluralize\Contracts\Pluralization;
use Illuminate\Support\Str;

class LaravelStrPluralization implements Pluralization
{
    public function run(string $string, $count): string
    {
        return Str::plural($string, $count);
    }
}