<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Reviews extends Resource
{
    /**
     * Get all reviews.
     *
     * @return Object
     */
    public function all(array $params = [])
    {
        $path = 'reviews';

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

    /**
     * Get a Review.
     *
     * @param int $id
     *
     * @return Object
     */
    public function getById($id, $params = [])
    {
      $path = 'reviews/'.$id;

      return $this->client->request(
        'get',
        $path,
        [],
        http_build_query($params)
      );
    }

    /**
     * Create a Review only for testing purposes.
     *
     * @param int $id
     *
     * @return Object
     */
    public function create(array $params = []): Object
    {
      $path = 'reviews';

      return $this->client->request(
        'post',
        $path,
        ['json' => $params],
      );
    }
}
