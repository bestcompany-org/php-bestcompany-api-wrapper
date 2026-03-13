<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class BsCompany extends Resource
{
    /**
     * Get a Company.
     *
     * @param  int  $id
     */
    public function getById($id, $params = []): object
    {
        $path = 'bs-companies/'.$id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

    /**
     * Get a BSCompany from a BCCompanyId.
     *
     * @param  int  $id
     */
    public function getByBcCompanyId($id, $params = []): object
    {
        $path = 'bs-companies/'.$id.'/bcid';

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }
}
