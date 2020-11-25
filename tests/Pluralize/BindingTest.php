<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Nedwors\Pluralize\Pluralize\Pluralize;
use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class BindingTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function a_default_fallback_can_be_bound()
    {
        Pluralize::bind('default')->fallback('Oops!');

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('Oops!', $string);
    }

    /** @test */
    public function a_default_output_can_be_bound()
    {
        Pluralize::bind('default')->output('You have some items');

        $string = Pluralize::this('Book')->from(1);
        $this->assertEquals('You have some items', $string);
    }

    /** @test */
    public function a_default_output_and_fallback_can_be_bound_at_the_same_time()
    {
        Pluralize::bind('default')
                    ->output('You have some items')
                    ->fallback('Oops!');

        $string = Pluralize::this('Book')->from(1);
        $this->assertEquals('You have some items', $string);

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('Oops!', $string);
    }

    /** @test */
    public function a_closure_can_be_bound_for_a_fallback()
    {
        Pluralize::bind('default')->fallback(fn() => 'Oops!');

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('Oops!', $string);
    }
}