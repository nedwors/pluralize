<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Nedwors\Pluralize\Pluralize\Pluralize;
use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class CountingTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function zero_is_counted_correctly()
    {
        $this->assertEquals("0 Books", Pluralize::this('Book')->from(0));
    }

    /** @test */
    public function it_can_count_from_integers()
    {
        $count = rand(2, 100);

        $this->assertEquals("$count Books", Pluralize::this('Book')->from($count));
    }

    /** @test */
    public function negative_numbers_will_be_counted()
    {
        $this->assertEquals("-1 Book", Pluralize::this('Book')->from(-1));

        $this->assertEquals("-2 Books", Pluralize::this('Book')->from(-2));
    }

    /** @test */
    public function it_can_count_from_number_of_items_in_an_array()
    {
        $items = collect(range(2, rand(3, 100)))->toArray();

        $this->assertEquals(count($items) . ' Books', Pluralize::this('Book')->from($items));
    }

    /** @test */
    public function it_can_count_from_number_of_items_in_a_collection()
    {
        $items = collect(range(2, rand(3, 100)));

        $this->assertEquals($items->count() . ' Books', Pluralize::this('Book')->from($items));
    }

    /** @test */
    public function it_can_count_from_a_lengthAwarePaginator()
    {
        $items = new LengthAwarePaginator([1,2,3,4,5], 5, 5);

        $this->assertEquals('5 Books', Pluralize::this('Book')->from($items));
    }

    /** @test */
    public function it_can_count_from_a_paginator()
    {
        $items = new Paginator([1,2,3,4,5], 5);

        $this->assertEquals('5 Books', Pluralize::this('Book')->from($items));
    }
}
