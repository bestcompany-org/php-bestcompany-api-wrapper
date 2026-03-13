<?php

namespace Bestcompany\BestcompanyApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see SnoballApi
 */
class SnoballApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SnoballApi::class;
    }
}
