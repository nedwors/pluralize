<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Pluralize;

class PluralizeTest extends TestCase
{
    /** @test */
    public function it_will_pluralize_a_string_according_to_the_items_passed()
    {
        $string = Pluralize::this('Book')->from(2);

        $this->assertEquals('2 Books', $string);
    }

    /** @test */
    public function it_will_handle_no_count_being_passed()
    {
        $string = Pluralize::this('Method');

        $this->assertEquals('-', $string);
    }

    /** @test */
    public function multiple_instances_can_be_generated_in_any_order()
    {
        $cats = Pluralize::this('Cat')->from(10);
        $dogs = Pluralize::this('Dog')->from(5);
        $dinosaurs = Pluralize::this('Dinosaur')->from(7);

        $this->assertEquals('5 Dogs', $dogs->go());
        $this->assertEquals('10 Cats', $cats->go());
        $this->assertEquals('7 Dinosaurs', $dinosaurs->go());
    }
}
