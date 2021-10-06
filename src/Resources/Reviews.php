<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Reviews extends Resource
{
    /**
     * Get all reviews.
     *
     * @return \Bestcompany\BestcompanyApi\Http\Client::request
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
     * @return \Bestcompany\BestcompanyApi\Http\Client::request
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
}
