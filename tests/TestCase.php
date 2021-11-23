<?php

namespace Nedwors\Pluralize\Tests;

use Nedwors\Pluralize\PluralizeServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [PluralizeServiceProvider::class];
    }
}
