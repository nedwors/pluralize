<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\PluralizeServiceProvider;
use Nedwors\Pluralize\Pluralize\Pluralize;
use Orchestra\Testbench\TestCase;

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
    
    /** @test */
    public function it_will_handle_no_count_being_passed()
    {
        $string = Pluralize::this('Method');

        $this->assertEquals('-', $string);
    }
}