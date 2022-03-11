<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Cache extends Resource
{
  /**
   * Flush cache object by tag.
   *
   * @param array $tags
   *   *
   * @return Object
   */
  public function flushByTags(array $tags = []): Object
  {
    $path = 'bs-user-notifications';

    return $this->client->request(
      'post',
      $path,
      ['json' => [
          'tags' => $tags
        ]
      ],
    );
  }
}
