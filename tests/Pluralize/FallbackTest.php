<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Nedwors\Pluralize\Facades\Pluralize;
use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class FallbackTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function if_a_fallback_is_provided_this_is_used_if_the_count_is_null()
    {
        $string = Pluralize::this('Book')->from(null)->or('-')();

        $this->assertEquals('-', $string);
    }

    /** @test */
    public function if_a_fallback_is_provided_but_there_is_a_count_this_is_used()
    {
        $string = Pluralize::this('Book')->from(0)->or('-')();

        $this->assertEquals('0 Books', $string);
    }

    /** @test */
    public function it_gracefully_handles_no_provided_fallback()
    {
        $string = Pluralize::this('Book')->from(null)();

        $this->assertEquals('-', $string);
    }

    /** @test */
    public function the_fallback_can_be_a_closure_that_is_passed_a_pluralized_form_of_the_item()
    {
        $string = Pluralize::this('Book')->from(null)->or(fn($items) => "There are no $items")();

        $this->assertEquals('There are no Books', $string);
    }
}