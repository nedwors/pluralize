<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Pluralize;

class HelperTest extends TestCase
{
    /** @test */
    public function an_item_and_a_count_can_be_passed()
    {
        $count = rand(2, 100);
        $string = pluralize('Computer', $count);

        $this->assertEquals("$count Computers", $string);
    }

    /** @test */
    public function the_second_call_to_from_will_set_the_count()
    {
        $count = rand(2, 100);
        $string = pluralize('Computer', 200)->from($count);

        $this->assertEquals("$count Computers", $string);
    }

    /** @test */
    public function a_third_paramater_can_be_passed_as_the_fallback()
    {
        $string = pluralize('Computer', null, 'Oops!');

        $this->assertEquals('Oops!', $string);
    }

    /** @test */
    public function the_last_fallback_is_used()
    {
        $string = pluralize('Computer', null, 'Oops!')->or('Woah there');

        $this->assertEquals('Woah there', $string);
    }

    /** @test */
    public function a_fourth_parameter_can_be_passed_to_define_the_display_form()
    {
        $string = pluralize('Computer', 10, 'Oops!', fn ($items, $count) => "There are $count $items");

        $this->assertEquals('There are 10 Computers', $string);
    }

    /** @test */
    public function it_can_be_accessed_purely_fluently()
    {
        $string = pluralize('Number')->from(0)->or('Oops');
        $this->assertEquals('0 Numbers', $string);

        $string = pluralize('Number')->from(null)->or('Oops');
        $this->assertEquals('Oops', $string);

        $string = pluralize('Number')->from(null)->or(fn ($items) => "There are no $items");
        $this->assertEquals('There are no Numbers', $string);

        $string = pluralize('Number')->from(100)->or(fn ($items) => "There are no $items");
        $this->assertEquals('100 Numbers', $string);
    }

    /** @test */
    public function complex_calls_render_accurately()
    {
        $string = pluralize('Test', null, fn ($items) => "You don't have any $items", 'This is the output')
                    ->as(fn ($items, $count) => "$count $items")
                    ->or('Whoops');

        $this->assertEquals('Whoops', $string);

        $string = pluralize('Test', 10, fn ($items) => "You don't have any $items")
                    ->as(fn ($items, $count) => "$count $items")
                    ->or('Whoops');

        $this->assertEquals('10 Tests', $string);

        $string = pluralize('Test', 10, fn ($items) => "You don't have any $items", fn ($string, $count) => "$count $string")
                    ->as(fn () => 'This is a pointless output')
                    ->or('Whoops');

        $this->assertEquals('This is a pointless output', $string);
    }

    /** @test */
    public function fallback_bindings_can_be_used()
    {
        Pluralize::bind()->fallback('-');

        $string = pluralize('Item', null);
        $this->assertEquals('-', $string);

        Pluralize::bind('ellipsis')->fallback('...');

        $string = pluralize('Item', null, 'ellipsis');
        $this->assertEquals('...', $string);
        $string = pluralize('Item', null)->or('ellipsis');
        $this->assertEquals('...', $string);

        Pluralize::bind('words')->fallback(fn ($items) => "No $items currently");

        $string = pluralize('Item', null, 'words');
        $this->assertEquals('No Items currently', $string);
        $string = pluralize('Item', null)->or('words');
        $this->assertEquals('No Items currently', $string);

        $string = pluralize('Item', null);
        $this->assertEquals('-', $string);
        $string = pluralize('Item', null)->or('ellipsis');
        $this->assertEquals('...', $string);
        $string = pluralize('Item', null, 'words');
        $this->assertEquals('No Items currently', $string);
    }
}
