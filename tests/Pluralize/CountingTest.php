<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Nedwors\Pluralize\Facades\Pluralize;
use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class CountingTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function it_can_count_from_integers()
    {
        $count = rand(2, 100);

        $this->assertEquals("$count Books", Pluralize::this('Book')->from($count)());
    }

    /** @test */
    public function it_can_count_from_number_of_items_in_an_array()
    {
        $items = collect(range(2, rand(3, 100)))->toArray();

        $this->assertEquals(count($items) . ' Books', Pluralize::this('Book')->from($items)());
    }

    /** @test */
    public function it_can_count_from_number_of_items_in_a_collection()
    {
        $items = collect(range(2, rand(3, 100)));

        $this->assertEquals($items->count() . ' Books', Pluralize::this('Book')->from($items)());
    }
}
