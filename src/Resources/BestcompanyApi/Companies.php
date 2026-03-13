<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Companies extends Resource
{
    /**
     * Get all companies.
     */
    public function all(array $params = []): object
    {
        $path = 'companies';

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

    /**
     * Get a Company.
     *
     * @param  int  $id
     */
    public function getById($id, $params = []): object
    {
        $path = 'companies/'.$id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

    public function recommendations($params = []): object
    {
        $path = 'companies/recommend';

        return $this->client->request(
            'post',
            $path,
            ['json' => $params],
        );
    }
}
