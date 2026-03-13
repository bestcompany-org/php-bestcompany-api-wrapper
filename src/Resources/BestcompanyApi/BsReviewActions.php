<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class BsReviewActions extends Resource
{
    /**
     * Create a access request.
     *
     * @param  array  $params  array of access request properties
     *                         *
     */
    public function create(array $params = []): object
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
     * @param  int  $id
     */
    public function getById($id, $params = []): object
    {
        $path = 'bs-review-actions/'.$id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }
}
