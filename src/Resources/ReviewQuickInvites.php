<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class ReviewQuickInvites extends Resource
{
    /**
     * Get all ReviewQuickInvites.
     *
     * @return Object
     */
    public function all(array $params = []): Object
    {
        $path = 'review-quick-invites';

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

    /**
     * Get an access request.
     *
     * @param int $id
     *
     * @return Object
     */
    public function getById($id, $params = []): Object
    {
        $path = 'review-quick-invites/' . $id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }
}
