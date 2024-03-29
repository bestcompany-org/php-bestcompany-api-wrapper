<?php

namespace Bestcompany\BestcompanyApi\Tests\V1;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class VerticalsTest extends BaseTestCase
{
  function test_it_requires_api_key(): void
  {
    $this->expectException(InvalidArgumentException::class);

    $api = new BestcompanyApi([
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $response = $api->verticals()->all();
  }

  function test_it_requires_valid_api_key(): void
  {
    $this->expectException(ClientException::class);

    $api = new BestcompanyApi([
      'key' => 'asdfasdf',
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $response = $api->verticals()->all();
    $this->assertEquals(401, $response->getResponse()->getStatusCode());
  }

  function test_all_verticals(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $data = $api->verticals()->all();
    $this->assertObjectHasProperty('meta', $data);
  }

  function test_single_vertical(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $data = $api->verticals()->getById(1);
    $data = $data->data;
    $this->assertObjectHasProperty('title', $data);
    $this->assertObjectHasProperty('slug', $data);
    $this->assertObjectHasProperty('maturity', $data);
  }
}
