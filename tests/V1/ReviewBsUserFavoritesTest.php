<?php

namespace Bestcompany\BestcompanyApi\Tests\V1;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class ReviewBsUserFavoritesTest extends BaseTestCase
{
  function test_it_requires_api_key(): void
  {
    $this->expectException(InvalidArgumentException::class);

    $api = new BestcompanyApi([
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $response = $api->reviewBsUserFavorites()->create();
  }

  function test_it_requires_valid_api_key(): void
  {
    $this->expectException(ClientException::class);

    $api = new BestcompanyApi([
      'key' => 'asdfasdf',
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $response = $api->reviewBsUserFavorites()->create();
    $this->assertEquals(401, $response->getResponse()->getStatusCode());
  }
}
