<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Tests\Pluralize\Mocks\MockPluralization;
use Nedwors\Pluralize\PluralizeServiceProvider;
use Nedwors\Pluralize\Pluralize\Pluralize;
use Orchestra\Testbench\TestCase;

class DriversTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function the_pluralization_driver_can_be_set()
    {
        Pluralize::driver(MockPluralization::class);

        $string = Pluralize::this('Foobar')->from(1);
        $this->assertEquals('1 This is a mock pluralization', $string);
    }
}