<?php

use Nedwors\Pluralize\Facades;
use Nedwors\Pluralize\Pluralize;

if(!function_exists('pluralize')) {
    function pluralize(string $item, $countable = null, $or = null, ?Closure $as = null): Pluralize
    {
        return Facades\Pluralize::this($item)->from($countable)->as($as)->or($or);
    }
}