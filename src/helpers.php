<?php

use Nedwors\Pluralize\Display\Display;
use Nedwors\Pluralize\Pluralize\Pluralize;

if (!function_exists('pluralize')) {
    function pluralize(string $item, $countable = null, $or = null, $as = null): Pluralize
    {
        return app(Pluralize::class)->this($item)->from($countable)->as($as)->or($or);
    }
}

if (!function_exists('display')) {
    function display(?string $item): Display
    {
        return app(Display::class)->this($item);
    }
}