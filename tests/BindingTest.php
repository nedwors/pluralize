<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\PluralizeServiceProvider;
use Nedwors\Pluralize\Pluralize\Pluralize;
use Orchestra\Testbench\TestCase;

class BindingTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function a_default_fallback_can_be_bound_by_calling_bind_with_no_arguments()
    {
        Pluralize::bind()->fallback('Oops!');

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('Oops!', $string);
    }

    /** @test */
    public function a_default_output_can_be_bound_by_calling_bind_with_no_arguments()
    {
        Pluralize::bind()->output('You have some items');

        $string = Pluralize::this('Book')->from(1);
        $this->assertEquals('You have some items', $string);
    }

    /** @test */
    public function a_default_output_and_fallback_can_be_bound_at_the_same_time()
    {
        Pluralize::bind()
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
        Pluralize::bind()->fallback(fn() => 'Oops!');

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('Oops!', $string);
    }

    /** @test */
    public function a_closure_can_be_bound_for_an_output()
    {
        Pluralize::bind()->output(fn($plural, $count) => "Currently, $count $plural");

        $string = Pluralize::this('Book')->from(10);
        $this->assertEquals('Currently, 10 Books', $string);
    }
}