<?php

namespace Bestcompany\BestcompanyApi\Resources\SnoballApi;

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
    $path = 'sales-rep-referral';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }
}
