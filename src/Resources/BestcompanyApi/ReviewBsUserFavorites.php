<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class ReviewBsUserFavorites extends Resource
{
    /**
     * Create a business user favorite review.
     *
     * @param  array  $params  array of access request properties
     *                         *
     */
    public function create(array $params = []): object
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
     * @param  mixed  $id
     */
    public function delete($id): object
    {
        $path = 'review-bsuser-favorites/'.$id;

        return $this->client->request(
            'delete',
            $path
        );
    }
}
