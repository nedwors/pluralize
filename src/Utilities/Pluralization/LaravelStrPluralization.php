<?php

namespace Nedwors\Pluralize\Utilities\Pluralization;

use Illuminate\Support\Str;
use Nedwors\Pluralize\Contracts\Pluralization;

class LaravelStrPluralization implements Pluralization
{
    public function run(string $string, $count): string
    {
        return Str::plural($string, $count);
    }
}
