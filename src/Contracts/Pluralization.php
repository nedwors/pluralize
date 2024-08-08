<?php

namespace Nedwors\Pluralize\Contracts;

interface Pluralization
{
    /**
     * Pluralizes the given singular string based on the count.
     *
     * @param  mixed  $count
     */
    public function run(string $string, $count): string;
}
