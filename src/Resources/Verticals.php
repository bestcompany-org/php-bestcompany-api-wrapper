<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Verticals extends Resource
{
  /**
   * Get all verticals.
   *
   * @return Object
   */
  public function all(array $params = []): Object
  {
    $path = 'verticals';

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }

  /**
   * Get a Vertical.
   *
   * @param int $id
   *
   * @return Object
   */
  public function getById($id, $params = []): Object
  {
    $path = 'verticals/' . $id;

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }
}
