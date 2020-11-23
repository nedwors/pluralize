<?php

namespace Nedwors\Pluralize;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nedwors\Pluralize\Skeleton\SkeletonClass
 */
class PluralizeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pluralize';
    }
}
