<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class CompanyPromotionalUrls extends Resource
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
    $path = 'company-promotional-urls/' . $id;

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
    $path = 'company-promotional-urls/' . $id . '/bcid';

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }

  /**
   * create CompanyPromotionalURL.
   *
   * @param int $id
   *
   * @return Object
   */
  public function create($params = []): Object
  {
    $path = 'company-promotional-urls';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }

  /**
   * update CompanyPromotionalURL.
   *
   * @param int $id
   *
   * @return Object
   */
  public function update($id, $params = []): Object
  {
    $path = 'company-promotional-urls/' . $id;

    return $this->client->request(
      'put',
      $path,
      ['json' => $params],
    );
  }

  /**
   * delete CompanyPromotionalURL.
   *
   * @param int $id
   *
   * @return Object
   */
  public function delete($id, $params = []): Object
  {
    $path = 'company-promotional-urls/' . $id;

    return $this->client->request(
      'delete',
      $path,
      ['json' => $params],
    );
  }
}
