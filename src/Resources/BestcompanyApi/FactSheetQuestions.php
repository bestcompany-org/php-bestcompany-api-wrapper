<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class FactSheetQuestions extends Resource
{
    /**
     * Get all FactSheetQuestions.
     */
    public function all(array $params = []): object
    {
        $path = 'fact-sheet-questions';

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
     * @param  int  $id
     */
    public function getById($id, $params = []): object
    {
        $path = 'fact-sheet-questions/'.$id;

        return $this->client->request(
            'get',
            $path,
            [],
            http_build_query($params)
        );
    }

    /**
     * Updates an access request.
     *
     * @param  int  $id  the access request id
     * @param  array  $params  the access request properties to update
     */
    public function update($id, $params = []): object
    {
        $path = 'fact-sheet-questions/'.$id;

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
        $path = 'fact-sheet-questions';

        return $this->client->request(
            'post',
            $path,
            ['json' => $params],
        );
    }
}
