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

    /**
     * Create a access request.
     *
     * @param array $params array of access request properties
     *   *
     * @return Object
     */
    public function create(array $params = []): Object
    {
        $path = 'review-quick-invites';

        return $this->client->request(
            'post',
            $path,
            ['json' => $params],
        );
    }
}
