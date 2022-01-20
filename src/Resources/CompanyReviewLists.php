<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class CompanyReviewLists extends Resource
{
  /**
   * Get all company-review-lists.
   *
   * @return Object
   */
  public function all(array $params = []): Object
  {
    $path = 'company-review-lists';

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }

    /**
     * Get a CompanyReviewLists.
     *
     * @param int $id
     *
     * @return Object
     */
    public function getById($id, $params = []): Object
    {
        $path = 'company-review-lists/' . $id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

  /**
   * Create a business user favorite review.
   *
   * @param array $params array of access request properties
   *   *
   * @return Object
   */
  public function create(array $params = []): Object
  {
    $path = 'company-review-lists';

    return $this->client->request(
      'post',
      $path,
      ['json' => $params],
    );
  }
  /**
   * Delete a business user favorite review.
   *
   * @param mixed $id
   *
   * @return Object
   */
  public function delete($id): Object
  {
    $path = 'company-review-lists/' . $id;

    return $this->client->request(
      'delete',
      $path
    );
  }
}
