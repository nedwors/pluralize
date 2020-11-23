<?php

namespace Nedwors\Pluralize\Tests;

use Orchestra\Testbench\TestCase;
use Nedwors\Pluralize\PluralizeServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
