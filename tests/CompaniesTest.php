<?php

namespace Bestcompany\BestcompanyApi\Tests;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class CompaniesTest extends BaseTestCase
{
    function test_it_requires_api_key(): void
    {
      $this->expectException(InvalidArgumentException::class);

      $api = new BestcompanyApi([
        'hostname' => $this->hostname
      ]);

      $response = $api->companies()->all();
    }

    function test_it_requires_valid_api_key(): void
    {
      $this->expectException(ClientException::class);

      $api = new BestcompanyApi([
        'key' => 'asdfasdf',
        'hostname' => $this->hostname
      ]);

      $response = $api->companies()->all();
      $this->assertEquals(401, $response->getResponse()->getStatusCode());
    }

    function test_all_companies(): void
    {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname
      ]);

      $data = $api->companies()->all();
      $this->assertIsArray($data->data);
    }

    function test_single_company(): void
    {
        $api = new BestcompanyApi([
            'key' => $this->key,
            'hostname' => $this->hostname
        ]);

        $data = $api->companies()->getById(1);
        $data = $data->data;
        $this->assertIsObject($data);
        $this->assertNotNull($data->title);
        $this->assertNotNull($data->slug);
        $this->assertNotNull($data->computed_rank);
        $this->assertNotNull($data->computed_score);
        $this->assertNotNull($data->vertical_id);
        $this->assertNotNull($data->thumbnail_url);
        $this->assertNotNull($data->star_rating);
    }

    function test_recommendation_of_companies(): void
    {
        $api = new BestcompanyApi([
          'key' => $this->key,
          'hostname' => $this->hostname
        ]);

        $data = $api->companies()->recommendations([
          'mstep_only' => true,
          'partners_only' => true
        ]);
        $this->assertNotNull($data->recommended_companies);
    }
}
