<?php

namespace Bestcompany\BestcompanyApi\Resources\SnoballApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class RepConversation extends Resource
{
    /**
     * Create a rep conversation.
     *
     * @param  array  $params  array of rep conversation properties
     */
    public function create(array $params = []): object
    {
        $path = 'rep-conversation';

        return $this->client->request(
            'post',
            $path,
            ['json' => $params],
        );
    }
}
