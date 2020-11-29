<?php

namespace Nedwors\Pluralize\Contracts;

interface Pluralization
{
    /**
     * Pluralizes the given singular string based on the count.
     *
     * @param string $string
     * @param mixed $count
     * @return string
     */
    public function run(string $string, $count): string;
}
