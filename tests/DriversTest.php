<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Pluralize;
use Nedwors\Pluralize\Tests\Mocks\MockPluralization;
use PHPUnit\Framework\Attributes\Test;

class DriversTest extends TestCase
{
    #[Test]
    public function the_pluralization_driver_can_be_set()
    {
        Pluralize::driver(MockPluralization::class);

        $string = Pluralize::this('Foobar')->from(1);
        $this->assertEquals('1 This is a mock pluralization', $string);
    }
}
