<?php

namespace Nedwors\Pluralize\Pluralize\Contracts;

interface Pluralization
{
    public function run(string $string, $count): string;
}