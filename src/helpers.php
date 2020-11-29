<?php

use Nedwors\Pluralize\Pluralize;

if (! function_exists('pluralize')) {
    function pluralize(string $item, $countable = null, $or = null, $as = null): Pluralize
    {
        return Pluralize::this($item)->from($countable)->as($as)->or($or);
    }
}
