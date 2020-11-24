<?php

namespace Nedwors\Pluralize\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nedwors\Pluralize\Skeleton\SkeletonClass
 */
class Display extends Facade
{
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(\Nedwors\Pluralize\Display\Display::class);
        
        return \Nedwors\Pluralize\Display\Display::class;
    }
}
