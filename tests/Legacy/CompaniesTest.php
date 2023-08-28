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

    // function test_all_companies(): void
    // {
    //   $api = new BestcompanyApi([
    //     'key' => $this->key,
    //     'hostname' => $this->hostname,
    //     'version' => ''
    //   ]);

    //   $data = $api->companies()->all();
    //   $this->assertObjectHasProperty('current_page', $data);
    // }

    function test_single_company(): void
    {
      $api = new BestcompanyApi([
        'key' => $this->key,
        'hostname' => $this->hostname,
        'version' => ''
      ]);

      $data = $api->companies()->getById(1);
      $data = $data->data;
      $this->assertObjectHasProperty('title', $data);
      $this->assertObjectHasProperty('slug', $data);
      $this->assertObjectHasProperty('computed_rank', $data);
      $this->assertObjectHasProperty('computed_score', $data);
      $this->assertObjectHasProperty('computed_user_score', $data);
      $this->assertObjectHasProperty('vertical_id', $data);
      $this->assertObjectHasProperty('payout_event', $data);
      $this->assertObjectHasProperty('phone_number', $data);
      $this->assertObjectHasProperty('thumbnail_url', $data);
      $this->assertObjectHasProperty('star_rating', $data);
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
        $this->assertObjectHasProperty('recommended_companies', $data);
    }
}
