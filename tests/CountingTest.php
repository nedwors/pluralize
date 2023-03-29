<?php

namespace Nedwors\Pluralize\Tests;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Nedwors\Pluralize\Pluralize;

class CountingTest extends TestCase
{
    /**
     * @dataProvider integersDataProvider
     *
     * @test
     */
    public function it_can_count_from_integers(int $integer, string $output)
    {
        $pluralized = Pluralize::this('Book')->from($integer)->__toString();

        $this->assertEquals($output, $pluralized);
    }

    public function integersDataProvider()
    {
        return [
            [0, '0 Books'],
            [1, '1 Book'],
            [2, '2 Books'],
            [-1, '-1 Book'],
            [-2, '-2 Books'],
        ];
    }

    /**
     * @dataProvider floatsDataProvider
     *
     * @test
     */
    public function it_can_count_from_floats(float $float, string $output)
    {
        $pluralized = Pluralize::this('Book')->from($float)->__toString();

        $this->assertEquals($output, $pluralized);
    }

    public function floatsDataProvider()
    {
        return [
            [0.0, '0 Books'],
            [0.1, '0.1 Books'],
            [1.0, '1 Book'],
            [1.5, '1.5 Book'],
            [2.2, '2.2 Books'],
            [-1.75, '-1.75 Book'],
            [-2.3, '-2.3 Books'],
        ];
    }

    /** @test */
    public function it_can_count_from_number_of_items_in_an_array()
    {
        $items = collect(range(2, rand(3, 100)))->toArray();

        $this->assertEquals(count($items).' Books', Pluralize::this('Book')->from($items));
    }

    /** @test */
    public function it_can_count_from_number_of_items_in_a_collection()
    {
        $items = collect(range(2, rand(3, 100)));

        $this->assertEquals($items->count().' Books', Pluralize::this('Book')->from($items));
    }

    /** @test */
    public function it_can_count_from_a_lengthAwarePaginator()
    {
        $items = new LengthAwarePaginator([1, 2, 3, 4, 5], 5, 5);

        $this->assertEquals('5 Books', Pluralize::this('Book')->from($items));
    }

    /** @test */
    public function it_can_count_from_a_paginator()
    {
        $items = new Paginator([1, 2, 3, 4, 5], 5);

        $this->assertEquals('5 Books', Pluralize::this('Book')->from($items));
    }

    /** @test */
    public function counts_will_not_affect_subsequent_instances()
    {
        $string = Pluralize::this('Cat')->from(20);
        $this->assertEquals('20 Cats', $string);

        $string = Pluralize::this('Cat');
        $this->assertEquals('-', $string);
    }
}
