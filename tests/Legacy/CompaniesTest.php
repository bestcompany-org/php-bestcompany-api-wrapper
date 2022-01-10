<?php

namespace Bestcompany\BestcompanyApi\Tests\Legacy;

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
        'hostname' => $this->hostname,
        'version' => ''
      ]);

      $response = $api->companies()->all();
    }

    function test_it_requires_valid_api_key(): void
    {
      $this->expectException(ClientException::class);

      $api = new BestcompanyApi([
        'key' => 'asdfasdf',
        'hostname' => $this->hostname,
        'version' => ''
      ]);

      $response = $api->companies()->all();
      $this->assertEquals(401, $response->getResponse()->getStatusCode());
    }

    function test_all_companies(): void
    {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname,
        'version' => ''
      ]);

      $data = $api->companies()->all();
      $this->assertObjectHasAttribute('current_page', $data);
    }

    function test_single_company(): void
    {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname,
        'version' => ''
      ]);

      $data = $api->companies()->getById(1);
      $data = $data->data;
      $this->assertObjectHasAttribute('title', $data);
      $this->assertObjectHasAttribute('slug', $data);
      $this->assertObjectHasAttribute('computed_rank', $data);
      $this->assertObjectHasAttribute('computed_score', $data);
      $this->assertObjectHasAttribute('computed_user_score', $data);
      $this->assertObjectHasAttribute('vertical_id', $data);
      $this->assertObjectHasAttribute('payout_event', $data);
      $this->assertObjectHasAttribute('phone_number', $data);
      $this->assertObjectHasAttribute('thumbnail_url', $data);
      $this->assertObjectHasAttribute('star_rating', $data);
    }

    function test_recommendation_of_companies(): void
    {
        $api = new BestcompanyApi([
          'key' => $this->key,
          'hostname' => $this->hostname,
          'version' => ''
        ]);

        $data = $api->companies()->recommendations([
          'mstep_only' => true,
          'partners_only' => true
        ]);
        $this->assertObjectHasAttribute('recommended_companies', $data);
    }
}
