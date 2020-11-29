<?php

namespace Nedwors\Pluralize\Tests\Mocks;

use Nedwors\Pluralize\Contracts\Pluralization;

class MockPluralization implements Pluralization
{
    public function run(string $string, $count): string
    {
        return 'This is a mock pluralization';
    }
}
