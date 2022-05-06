<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class BsCompany extends Resource
{
  /**
   * Get a Company.
   *
   * @param int $id
   *
   * @return Object
   */
  public function getById($id, $params = []): Object
  {
    $path = 'bs-companies/' . $id;

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }

  /**
   * Get a BSCompany from a BCCompanyId.
   *
   * @param int $id
   *
   * @return Object
   */
  public function getByBcCompanyId($id, $params = []): Object
  {
    $path = 'bs-companies/' . $id . 'bcid';

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }
}
