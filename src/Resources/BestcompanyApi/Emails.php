<?php

namespace Bestcompany\BestcompanyApi\Resources\BestcompanyApi;

use Bestcompany\BestcompanyApi\Resources\Resource;

class Emails extends Resource
{
  /**
   * Get a Email.
   *
   * @param string $name
   *
   * @return Object
   */
  public function getByName($name, $params = []): Object
  {
    $path = 'emails/' . $name;

    return $this->client->request(
      'get',
      $path,
      [],
      http_build_query($params)
    );
  }

}
