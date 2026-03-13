<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class CompanyReviewLists extends Resource
{
    /**
     * Get all company-campaigns.
     */
    public function all(array $params = []): object
    {
        $path = 'company-campaigns';

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
     * @param  int  $id
     */
    public function getById($id, $params = []): object
    {
        $path = 'company-campaigns/'.$id;

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
     * @param  array  $params  array of access request properties
     *                         *
     */
    public function create(array $params = []): object
    {
        $path = 'company-campaigns';

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
        $path = 'company-campaigns/'.$id;

        return $this->client->request(
            'delete',
            $path
        );
    }
}
