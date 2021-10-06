<?php

namespace Bestcompany\BestcompanyApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bestcompany\BestcompanyApi\Skeleton\SkeletonClass
 */
class BestcompanyApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bestcompany-api';
    }
}
