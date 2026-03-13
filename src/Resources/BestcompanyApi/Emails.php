<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Emails extends Resource
{
    /**
     * Get a Email.
     *
     * @param  string  $name
     */
    public function getByName($name, $params = []): object
    {
        $path = 'emails/'.$name;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }
}
