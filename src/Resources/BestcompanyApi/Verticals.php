<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Verticals extends Resource
{
    /**
     * Get all verticals.
     */
    public function all(array $params = []): object
    {
        $path = 'verticals';

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

    /**
     * Get a Vertical.
     *
     * @param  int  $id
     */
    public function getById($id, $params = []): object
    {
        $path = 'verticals/'.$id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }
}
