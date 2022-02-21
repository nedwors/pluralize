<?php

use Nedwors\Pluralize\Pluralize;
use Nedwors\Pluralize\Utilities\Pluralizer;

if (!function_exists('pluralize')) {
    function pluralize(string $item, $countable = null, $or = null, $as = null): Pluralizer
    {
        return Pluralize::this($item)->from($countable)->as($as)->or($or);
    }
}
