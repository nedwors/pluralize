<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Illuminate\Support\Collection;
use Nedwors\Pluralize\Facades\Pluralize;
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
        $string = Pluralize::this('Book')->from(2)();

        $this->assertEquals('2 Books', $string);
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

    /** @test */
    public function if_a_fallback_is_provided_this_is_used_if_the_count_is_null()
    {
        $string = Pluralize::this('Book')->from(null)->or('-');

        $this->assertEquals('-', $string);
    }

    /** @test */
    public function if_a_fallback_is_provided_but_there_is_a_count_this_is_used()
    {
        $string = Pluralize::this('Book')->from(0)->or('-');

        $this->assertEquals('0 Books', $string);
    }

    /** @test */
    public function it_gracefully_handles_no_provided_fallback()
    {
        $string = Pluralize::this('Book')->from(null)();

        $this->assertEquals('-', $string);
    }
}
