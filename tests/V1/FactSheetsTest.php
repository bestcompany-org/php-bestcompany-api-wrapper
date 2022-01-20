<?php

namespace Bestcompany\BestcompanyApi\Tests\V1;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class FactSheetsTest extends BaseTestCase
{
  function test_it_requires_api_key(): void
  {
    $this->expectException(InvalidArgumentException::class);

    $api = new BestcompanyApi([
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $response = $api->factSheets()->all();
  }

  function test_it_requires_valid_api_key(): void
  {
    $this->expectException(ClientException::class);

    $api = new BestcompanyApi([
      'key' => 'asdfasdf',
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $response = $api->factSheets()->all();
    $this->assertEquals(401, $response->getResponse()->getStatusCode());
  }

  function test_all_fact_sheet_requests(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $data = $api->factSheets()->all();
    $this->assertObjectHasAttribute('meta', $data);
  }

  function test_single_fact_sheet_request(): void
  {
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $data = $api->factSheets()->getById(1);
    $this->assertObjectHasAttribute('id', $data);
    $this->assertObjectHasAttribute('name', $data);
    $this->assertObjectHasAttribute('email', $data);
    $this->assertObjectHasAttribute('avatar', $data);
    $this->assertObjectHasAttribute('company_id', $data);
    $this->assertObjectHasAttribute('approved', $data);
    $this->assertObjectHasAttribute('created_at', $data);
    $this->assertObjectHasAttribute('updated_at', $data);
  }

  function test_updating_fact_sheet_request(): void
  {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname,
        'version' => 'v1'
      ]);

      $data = $api->factSheets()->update(1, [
        'approved' => 1
      ]);
      $this->assertEquals($data->id, 1);
      $this->assertEquals($data->approved, 1);
      $data = $api->factSheets()->update(1, [
        'approved' => 0
      ]);
      $this->assertEquals($data->id, 1);
      $this->assertEquals($data->approved, 0);
  }

  function test_creating_fact_sheet_request(): void
  {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname,
        'version' => 'v1'
      ]);

      $formData = [
        'name' => 'test name',
        'email' => 'technology@bestcompany.com',
        'avatar' => 'https://via.placeholder.com/400',
        'company_id' => 471,
        'approved' => 0
      ];

      $data = $api->factSheets()->create($formData);

      $this->assertObjectHasAttribute('id', $data);
      $this->assertEquals($data->name, $formData['name']);
      $this->assertEquals($data->email, $formData['email']);
      $this->assertEquals($data->avatar, $formData['avatar']);
      $this->assertEquals($data->company_id, $formData['company_id']);
      $this->assertEquals($data->approved, $formData['approved']);
  }
}