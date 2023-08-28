<?php

namespace Bestcompany\BestcompanyApi\Tests\Legacy;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class ReviewMessageTest extends BaseTestCase
{
  function test_it_requires_api_key(): void
  {
    $this->expectException(InvalidArgumentException::class);

    $api = new BestcompanyApi([
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $response = $api->reviewMessage()->all();
  }

  function test_it_requires_valid_api_key(): void
  {
    $this->expectException(ClientException::class);

    $api = new BestcompanyApi([
      'key' => 'asdfasdf',
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $response = $api->reviewMessage()->all();
    $this->assertEquals(401, $response->getResponse()->getStatusCode());
  }

  function test_updating_access_request(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $data = $api->reviewMessage()->update(1, [
      'public' => 1
    ]);
    $this->assertEquals($data->id, 1);
    $this->assertEquals($data->public, 1);
    $data = $api->reviewMessage()->update(1, [
      'public' => 0
    ]);
    $this->assertEquals($data->id, 1);
    $this->assertEquals($data->public, 0);
  }

  function test_creating_access_request(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $formData = [
      'review_id' => 1,
      'messenger_type' => 'company_user',
      'message' => 'This is a test message',
      'messenger_id' => 1,
      'public' => 0
    ];

    $data = $api->reviewMessage()->create($formData);

    $this->assertObjectHasProperty('id', $data);
    $this->assertEquals($data->review_id, $formData['review_id']);
    $this->assertEquals($data->messenger_type, $formData['messenger_type']);
    $this->assertEquals($data->message, $formData['message']);
    $this->assertEquals($data->messenger_id, $formData['messenger_id']);
    $this->assertEquals($data->public, $formData['public']);
  }
}
