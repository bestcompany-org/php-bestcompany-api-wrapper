<?php

namespace Bestcompany\BestcompanyApi\Tests\Legacy;

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
      'version' => ''
    ]);

    $response = $api->reviewBsUserFavorites()->create();
  }

  function test_it_requires_valid_api_key(): void
  {
    $this->expectException(ClientException::class);

    $api = new BestcompanyApi([
      'key' => 'asdfasdf',
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $response = $api->reviewBsUserFavorites()->create();
    $this->assertEquals(401, $response->getResponse()->getStatusCode());
  }

  // function test_it_creates_a_favorite(): void
  // {
  //     $api = new BestcompanyApi([
  //       'key' => $this->key,
  //       'hostname' => $this->hostname,
  //       'version' => ''
  //     ]);

  //     $formData = [
  //       'review_id' => 3,
  //       'user_id' => 1
  //     ];

  //     $data = $api->reviewBsUserFavorites()->create($formData);

  //     $this->assertObjectHasProperty('id', $data);
  //     $this->assertEquals($data->review_id, $formData['review_id']);
  //     $this->assertEquals($data->user_id, $formData['user_id']);
  // }
}
