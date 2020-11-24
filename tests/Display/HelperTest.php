<?php

namespace Nedwors\Pluralize\Tests\Display;

use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class HelperTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }
    
    /** @test */
    public function it_will_display_a_string_when_not_null()
    {
        $string = display('Book');

        $this->assertEquals('Book', $string);
    }
    
    /** @test */
    public function it_will_display_a_fallback_when_null()
    {
        $string = display(null);

        $this->assertEquals('-', $string);
    }
}
