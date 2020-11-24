<?php

use Nedwors\Pluralize\Facades;
use Nedwors\Pluralize\Pluralize\Pluralize;

if(!function_exists('pluralize')) {
    function pluralize(string $item, $countable = null, $or = null, $as = null): Pluralize
    {
        return Facades\Pluralize::this($item)->from($countable)->as($as)->or($or);
    }
}