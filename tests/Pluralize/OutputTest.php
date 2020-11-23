<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Nedwors\Pluralize\Facades\Pluralize;
use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class OutputTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function the_output_of_the_pluralization_can_be_defined()
    {
        $string = Pluralize::this('Book')->from(15)->as(fn($items, $count) => "You have $count $items")();
        $this->assertEquals('You have 15 Books', $string);

        $string = Pluralize::this('Book')->from(15)->as(fn($items, $count) => "Yay, $count $items")();
        $this->assertEquals('Yay, 15 Books', $string);
    }

    /** @test */
    public function singular_and_plural_variations_can_be_set_in_the_string_with_a_pipe_operator()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn($items, $count) => "There is|are $count $items")();
        $this->assertEquals('There is 1 Book', $string);

        $string = Pluralize::this('Book')->from(2)->as(fn($items, $count) => "There is|are $count $items")();
        $this->assertEquals('There are 2 Books', $string);
    }

    /** @test */
    public function it_can_handle_multiple_variations()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn($items, $count) => "There is|are $count $items, as there is|are $count $items")();
        $this->assertEquals('There is 1 Book, as there is 1 Book', $string);
    
        $string = Pluralize::this('Book')->from(3)->as(fn($items, $count) => "There is|are $count $items, as there is|are $count $items")();
        $this->assertEquals('There are 3 Books, as there are 3 Books', $string);
    }
}