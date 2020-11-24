<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Nedwors\Pluralize\Pluralize\Pluralize;
use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class PluralizeTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }
    
    /** @test */
    public function it_will_pluralize_a_string_according_to_the_items_passed()
    {
        $string = Pluralize::this('Book')->from(2);

        $this->assertEquals('2 Books', $string);
    }
}