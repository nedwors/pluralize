<?php

namespace Nedwors\Pluralize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nedwors\Pluralize\Skeleton\SkeletonClass
 */
class Pluralize extends Facade
{
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(\Nedwors\Pluralize\Pluralize\Pluralize::class);
        
        return \Nedwors\Pluralize\Pluralize\Pluralize::class;
    }
}
