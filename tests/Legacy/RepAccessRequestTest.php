<?php

namespace Bestcompany\BestcompanyApi\Tests\Legacy;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class RepAccessRequestTest extends BaseTestCase
{
  function test_it_requires_api_key(): void
  {
    $this->expectException(InvalidArgumentException::class);

    $api = new BestcompanyApi([
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $response = $api->repAccessRequest()->all();
  }

  function test_it_requires_valid_api_key(): void
  {
    $this->expectException(ClientException::class);

    $api = new BestcompanyApi([
      'key' => 'asdfasdf',
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $response = $api->repAccessRequest()->all();
    $this->assertEquals(401, $response->getResponse()->getStatusCode());
  }

  function test_all_access_requests(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $data = $api->repAccessRequest()->all();
    $this->assertObjectHasProperty('current_page', $data);
  }

  function test_single_access_request(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => ''
    ]);

    $data = $api->repAccessRequest()->getById(1);
    $this->assertObjectHasProperty('id', $data);
    $this->assertObjectHasProperty('name', $data);
    $this->assertObjectHasProperty('email', $data);
    $this->assertObjectHasProperty('avatar', $data);
    $this->assertObjectHasProperty('company_id', $data);
    $this->assertObjectHasProperty('is_approved', $data);
    $this->assertObjectHasProperty('created_at', $data);
    $this->assertObjectHasProperty('updated_at', $data);
  }

  function test_updating_access_request(): void
  {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname,
        'version' => ''
      ]);

      $data = $api->repAccessRequest()->update(1, [
        'is_approved' => 1
      ]);
      $this->assertEquals($data->id, 1);
      $this->assertEquals($data->is_approved, 1);
      $data = $api->repAccessRequest()->update(1, [
        'is_approved' => 0
      ]);
      $this->assertEquals($data->id, 1);
      $this->assertEquals($data->is_approved, 0);
  }

  function test_creating_access_request(): void
  {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname,
        'version' => ''
      ]);

      $formData = [
        'name' => 'test name',
        'email' => 'technology@bestcompany.com',
        'avatar' => 'https://via.placeholder.com/400',
        'company_id' => 471,
        'is_approved' => 0,
        'field_rep_id' => 'zzwBKhRbbVQjk5xjZMAw7ZsR7t52'
      ];

      $data = $api->repAccessRequest()->create($formData);

      $this->assertObjectHasProperty('id', $data);
      $this->assertEquals($data->name, $formData['name']);
      $this->assertEquals($data->email, $formData['email']);
      $this->assertEquals($data->avatar, $formData['avatar']);
      $this->assertEquals($data->company_id, $formData['company_id']);
      $this->assertEquals($data->is_approved, $formData['is_approved']);
  }
}
