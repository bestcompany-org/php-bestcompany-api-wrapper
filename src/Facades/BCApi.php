<?php

namespace Bestcompany\BestcompanyApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bestcompany\BestcompanyApi\Skeleton\SkeletonClass
 */
class BCApi extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'bc-api';
  }
}
