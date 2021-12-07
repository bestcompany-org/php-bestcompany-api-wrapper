<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class ReviewBsUserFavorites extends Resource
{
    /**
     * Create a business user favorite review.
     *
     * @param array $params array of access request properties
     *   *
     * @return Object
     */
    public function create(array $params = []): Object
    {
      $path = 'review-bsuser-favorites';

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
      $path = 'review-bsuser-favorites/'.$id;

      return $this->client->request(
        'delete',
        $path
      );
    }
}
