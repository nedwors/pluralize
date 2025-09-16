<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Pluralize;
use PHPUnit\Framework\Attributes\Test;

class FallbackTest extends TestCase
{
    #[Test]
    public function if_a_fallback_is_provided_this_is_used_if_the_count_is_null()
    {
        $string = Pluralize::this('Book')->from(null)->or('-');

        $this->assertEquals('-', $string);
    }

    #[Test]
    public function if_a_fallback_is_provided_but_there_is_a_count_this_is_used()
    {
        $string = Pluralize::this('Book')->from(0)->or('-');

        $this->assertEquals('0 Books', $string);
    }

    #[Test]
    public function it_gracefully_handles_no_provided_fallback()
    {
        $string = Pluralize::this('Book')->from(null);

        $this->assertEquals('-', $string);
    }

    #[Test]
    public function the_fallback_can_be_a_closure_that_is_passed_a_pluralized_form_of_the_item()
    {
        $string = Pluralize::this('Book')->from(null)->or(fn ($items) => "There are no $items");

        $this->assertEquals('There are no Books', $string);
    }

    #[Test]
    public function a_custom_default_fallback_can_be_bound_into_the_service_container()
    {
        Pluralize::bind()->fallback(fn () => 'Nothing was counted');

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('Nothing was counted', $string);
    }

    #[Test]
    public function a_custom_default_fallback_can_be_bound_into_the_service_container_that_takes_the_plural_string_as_a_parameter()
    {
        Pluralize::bind()->fallback(fn ($items) => "No $items were counted");

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('No Books were counted', $string);
    }

    #[Test]
    public function custom_fallbacks_can_be_resolved_at_time_of_access()
    {
        Pluralize::bind('question-mark-fallback')->fallback('???');
        Pluralize::bind('ellipsis-fallback')->fallback('...');

        $string = Pluralize::this('Book')->from(null)->or('question-mark-fallback');
        $this->assertEquals('???', $string);

        $string = Pluralize::this('Book')->from(null)->or('ellipsis-fallback');
        $this->assertEquals('...', $string);
    }

    #[Test]
    public function a_binding_can_be_made_that_matches_the_singular_word_passed()
    {
        Pluralize::bind('Book')->fallback('There are no books');

        $string = Pluralize::this('Book')->from(null);
        $this->assertEquals('There are no books', $string);
    }
}
