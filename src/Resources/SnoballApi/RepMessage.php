<?php

namespace Bestcompany\BestcompanyApi\Resources\SnoballApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class RepMessage extends Resource
{
  /**
   * Create a rep message.
   *
   * @param array $params array of access request properties
   *   *
   * @return Object
   */
  public function create(array $params = []): Object
  {
    $path = 'rep-message';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }
}

