<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Pluralize;
use Nedwors\Pluralize\Tests\Mocks\MockPluralization;

class DriversTest extends TestCase
{
    /** @test */
    public function the_pluralization_driver_can_be_set()
    {
        Pluralize::driver(MockPluralization::class);

        $string = Pluralize::this('Foobar')->from(1);
        $this->assertEquals('1 This is a mock pluralization', $string);
    }
}
