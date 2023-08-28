<?php

namespace Bestcompany\BestcompanyApi\Tests;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Testing\WithFaker;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class RepAccessRequestTest extends BaseTestCase
{
  use WithFaker;

  function test_it_requires_api_key(): void
  {
    $this->expectException(InvalidArgumentException::class);

    $api = new BestcompanyApi([
      'hostname' => $this->hostname
    ]);

    $response = $api->repAccessRequest()->all();
  }

  function test_it_requires_valid_api_key(): void
  {
    $this->expectException(ClientException::class);

    $api = new BestcompanyApi([
      'key' => 'asdfasdf',
      'hostname' => $this->hostname
    ]);

    $response = $api->repAccessRequest()->all();
    $this->assertEquals(401, $response->getResponse()->getStatusCode());
  }

  function test_all_access_requests(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname
    ]);

    $data = $api->repAccessRequest()->all();
    $this->assertNotNull($data->current_page);
  }

  function test_single_access_request(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname
    ]);

    $data = $api->repAccessRequest()->getById(1);

    $this->assertNotNull($data->id);
    $this->assertNotNull($data->name);
    $this->assertNotNull($data->email);
    $this->assertNotNull($data->avatar);
    $this->assertNotNull($data->company_id);
    $this->assertNotNull($data->is_approved);
    $this->assertNotNull($data->created_at);
    $this->assertNotNull($data->updated_at);
  }

  function test_updating_access_request(): void
  {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname
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
        'hostname' => $this->hostname
      ]);

      $formData = [
        'name' => 'test name',
        'email' => 'technology@bestcompany.com',
        'avatar' => 'https://via.placeholder.com/400',
        'company_id' => 691,
        'is_approved' => 0,
        'field_rep_id' => 'zzwBKhRbbVQjk5xjZMAw7ZsR7t52'
      ];

      $data = $api->repAccessRequest()->create($formData);

      $this->assertNotNull($data->id);
      $this->assertEquals($data->name, $formData['name']);
      $this->assertEquals($data->email, $formData['email']);
      $this->assertEquals($data->avatar, $formData['avatar']);
      $this->assertEquals($data->company_id, $formData['company_id']);
      $this->assertEquals($data->is_approved, $formData['is_approved']);
  }
}
