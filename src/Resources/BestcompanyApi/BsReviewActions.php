<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class BsReviewActions extends Resource
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
      $path = 'bs-review-actions';

      return $this->client->request(
        'post',
        $path,
        ['json' => $params],
      );
    }

    /**
     * Get an Action.
     *
     * @param int $id
     *
     * @return Object
     */
    public function getById($id, $params = []): Object
    {
      $path = 'bs-review-actions/' . $id;

      return $this->client->request(
        'get',
        $path,
        [],
        http_build_query($params)
      );
    }
}
