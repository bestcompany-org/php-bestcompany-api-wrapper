<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class SalesRepReferral extends Resource
{
  /**
   * Create a access request.
   *
   * @param array $params array of access request properties
   *   *
   * @return Object
   */
  public function create(array $params = []): Object
  {
    $path = 'sales-rep-referrals';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }
}
