<?php

namespace Nedwors\Pluralize\Tests\Pluralize;

use Nedwors\Pluralize\Pluralize\Pluralize;
use Nedwors\Pluralize\Pluralize\Utilities\Container;
use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class ContainerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }

    /** @test */
    public function a_binding_can_be_bound_as_an_output()
    {
        $container = app(Container::class);

        $container->bind('Book')->output('Hello');

        $this->assertTrue($container->hasOutput('Book'));
        $this->assertEquals('Hello', $container->getOutput('Book'));
    }

    /** @test */
    public function a_binding_can_be_bound_as_a_fallback()
    {
        $container = app(Container::class);

        $container->bind('Book')->fallback('Hello');

        $this->assertTrue($container->hasFallback('Book'));
        $this->assertEquals('Hello', $container->getFallback('Book'));
    }

    /** @test */
    public function the_same_key_can_be_fluently_bound()
    {
        $container = app(Container::class);

        $container->bind('Book')->fallback('Hello')->output('Goodbye');

        $this->assertTrue($container->hasFallback('Book'));
        $this->assertEquals('Hello', $container->getFallback('Book'));

        $this->assertTrue($container->hasOutput('Book'));
        $this->assertEquals('Goodbye', $container->getOutput('Book'));
    }
}