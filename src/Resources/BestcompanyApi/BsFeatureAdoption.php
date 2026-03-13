<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class BsFeatureAdoption extends Resource
{
    /**
     * Updates an access request.
     *
     * @param  int  $id  the access request id
     * @param  array  $params  the access request properties to update
     */
    public function update($id, $params = []): object
    {
        $path = 'bs-feature-adoptions/'.$id;

        return $this->client->request(
            'put',
            $path,
            ['json' => $params],
        );
    }

    /**
     * Create a access request.
     *
     * @param  array  $params  array of access request properties
     *                         *
     */
    public function create(array $params = []): object
    {
        $path = 'bs-feature-adoptions';

        return $this->client->request(
            'post',
            $path,
            ['json' => $params],
        );
    }

    /**
     * Get a FeatureAdoption by company id.
     *
     * @param  int  $id
     * @return object
     */
    public function getByCompanyId($id, $params = [])
    {
        $path = 'bs-feature-adoptions/company/'.$id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }
}
