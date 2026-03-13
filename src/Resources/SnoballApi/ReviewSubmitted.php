<?php

namespace Bestcompany\BestcompanyApi\Resources\SnoballApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class ReviewSubmitted extends Resource
{
    /**
     * Notify Snoball that a review was submitted.
     *
     * @param  array  $params  array containing review_id
     */
    public function create(array $params = []): object
    {
        $path = 'review-submitted';

        return $this->client->request(
            'post',
            $path,
            ['json' => $params],
        );
    }
}
