<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\Utilities\Container\Container;
use PHPUnit\Framework\Attributes\Test;

class ContainerTest extends TestCase
{
    #[Test]
    public function a_binding_can_be_bound_as_an_output()
    {
        $container = app(Container::class);

        $container->bind('Book')->output('Hello');

        $this->assertTrue($container->outputs->has('Book'));
        $this->assertEquals('Hello', $container->outputs->get('Book'));
    }

    #[Test]
    public function a_binding_can_be_bound_as_a_fallback()
    {
        $container = app(Container::class);

        $container->bind('Book')->fallback('Hello');

        $this->assertTrue($container->fallbacks->has('Book'));
        $this->assertEquals('Hello', $container->fallbacks->get('Book'));
    }

    #[Test]
    public function the_same_key_can_be_fluently_bound()
    {
        $container = app(Container::class);

        $container->bind('Book')->fallback('Hello')->output('Goodbye');

        $this->assertTrue($container->fallbacks->has('Book'));
        $this->assertEquals('Hello', $container->fallbacks->get('Book'));

        $this->assertTrue($container->outputs->has('Book'));
        $this->assertEquals('Goodbye', $container->outputs->get('Book'));
    }
}
