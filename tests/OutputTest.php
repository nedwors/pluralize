<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Pluralize;
use Nedwors\Pluralize\PluralizeServiceProvider;
use Orchestra\Testbench\TestCase;

class OutputTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function the_output_of_the_pluralization_can_be_defined()
    {
        $string = Pluralize::this('Book')->from(15)->as(fn ($items, $count) => "You have $count $items");
        $this->assertEquals('You have 15 Books', $string);

        $string = Pluralize::this('Book')->from(15)->as(fn ($items, $count) => "Yay, $count $items");
        $this->assertEquals('Yay, 15 Books', $string);
    }

    /** @test */
    public function singular_and_plural_variations_can_be_set_in_the_string_with_a_pipe_operator()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn ($items, $count) => "There is|are $count $items");
        $this->assertEquals('There is 1 Book', $string);

        $string = Pluralize::this('Book')->from(2)->as(fn ($items, $count) => "There is|are $count $items");
        $this->assertEquals('There are 2 Books', $string);
    }

    /** @test */
    public function it_can_handle_multiple_variations()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn ($items, $count) => "There is|are $count $items, as there is|are $count $items");
        $this->assertEquals('There is 1 Book, as there is 1 Book', $string);

        $string = Pluralize::this('Book')->from(3)->as(fn ($items, $count) => "There is|are $count $items, as there is|are $count $items");
        $this->assertEquals('There are 3 Books, as there are 3 Books', $string);
    }

    /** @test */
    public function it_can_handle_different_delimited_strings()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn () => 'Why|What would|do you do|want this');
        $this->assertEquals('Why would you do this', $string);

        $string = Pluralize::this('Book')->from(0)->as(fn () => 'Why|What would|do you do|want this|friend');
        $this->assertEquals('What do you want friend', $string);

        $string = Pluralize::this('Book')->from(2)->as(fn () => 'Why|What would|do you do|want this|friend');
        $this->assertEquals('What do you want friend', $string);
    }

    /** @test */
    public function it_can_handle_pipe_delimited_numbers()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn ($items, $count) => "Show me the $count|$items");
        $this->assertEquals('Show me the 1', $string);

        $string = Pluralize::this('Book')->from(2)->as(fn ($items, $count) => "Show me the $count|$items");
        $this->assertEquals('Show me the Books', $string);

        $string = Pluralize::this('Book')->from(1)->as(fn () => '42|007');
        $this->assertEquals('42', $string);

        $string = Pluralize::this('Book')->from(2)->as(fn () => '42|007');
        $this->assertEquals('007', $string);
    }

    /** @test */
    public function it_can_handle_pipe_delimited_synbols()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn () => '&!|!-');
        $this->assertEquals('&!', $string);

        $string = Pluralize::this('Book')->from(2)->as(fn () => '&!|!-');
        $this->assertEquals('!-', $string);
    }

    /** @test */
    public function pipe_delimiting_features_are_available_to_strings()
    {
        $string = Pluralize::this('Book')->from(1)->as('Show me the prizes|money');
        $this->assertEquals('Show me the prizes', $string);

        $string = Pluralize::this('Book')->from(2)->as('Show me the prizes|money');
        $this->assertEquals('Show me the money', $string);
    }

    /** @test */
    public function pipe_delimiting_features_are_available_to_strings_for_negative_one()
    {
        $string = Pluralize::this('Book')->from(1)->as(fn ($plural, $count) => "There is|are $count $plural");
        $this->assertEquals('There is 1 Book', $string);

        $string = Pluralize::this('Book')->from(-1)->as(fn ($plural, $count) => "There is|are $count $plural");
        $this->assertEquals('There is -1 Book', $string);
    }

    /** @test */
    public function a_default_format_can_be_bound()
    {
        Pluralize::bind()->output(fn ($items, $count) =>  "There are $count $items");

        $string = Pluralize::this('Book')->from(10);
        $this->assertEquals('There are 10 Books', $string);
    }

    /** @test */
    public function a_default_format_is_overriden_by_the_declared_output()
    {
        Pluralize::bind()->output(fn ($items, $count) =>  "There are $count $items");

        $string = Pluralize::this('Book')->from(10)->as(fn ($items, $count) => "$items - $count");
        $this->assertEquals('Books - 10', $string);
    }

    /** @test */
    public function a_default_output_can_be_bound_to_the_singular_form_of_the_word_passed()
    {
        Pluralize::bind('Pizza')->output('Luke has some pizzas!');

        $string = Pluralize::this('Pizza')->from(10);
        $this->assertEquals('Luke has some pizzas!', $string);
    }
}
