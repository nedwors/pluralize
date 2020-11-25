<?php

namespace Nedwors\Pluralize\Pluralize\Contracts;

interface PluralizationEngine
{
    public function run(string $string, $count): string;
}