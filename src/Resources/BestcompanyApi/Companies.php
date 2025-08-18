<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Companies extends Resource
{
  /**
   * Get all companies.
   *
   * @return Object
   */
  public function all(array $params = []): Object
  {
    $path = 'companies';

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }

  /**
   * Get a Company.
   *
   * @param int $id
   *
   * @return Object
   */
  public function getById($id, $params = []): Object
  {
    $path = 'companies/' . $id;

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }

  public function recommendations($params = []): Object
  {
    $path = 'companies/recommend';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }
}
