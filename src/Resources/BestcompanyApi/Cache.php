<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Cache extends Resource
{
    /**
     * Flush cache object by tag.
     *
     *   *
     */
    public function flushByTags(array $tags = []): object
    {
        $path = 'cache-flush';

        return $this->client->request(
            'post',
            $path,
            ['json' => [
                'tags' => $tags,
            ],
            ],
        );
    }
}
