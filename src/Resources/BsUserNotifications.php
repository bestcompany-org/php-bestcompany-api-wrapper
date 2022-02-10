<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class BsUserNotifications extends Resource
{
  /**
   * Get an access request.
   *
   * @param int $id
   *
   * @return Object
   */
  public function getById($id, $params = []): Object
  {
    $path = 'bs-user-notifications/' . $id;

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }
  /**
   * Updates an access request.
   *
   * @param int   $id         the access request id
   * @param array $params the access request properties to update
   *
   * @return Object
   */
  public function update($id, $params = []): Object
  {
    $path = 'bs-user-notifications/' . $id;

    return $this->client->request(
      'put',
      $path,
      ['json' => $params],
    );
  }

  /**
   * Create a access request.
   *
   * @param array $params array of access request properties
   *   *
   * @return Object
   */
  public function create(array $params = []): Object
  {
    $path = 'bs-user-notifications';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }
}
