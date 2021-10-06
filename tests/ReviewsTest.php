<?php

namespace Bestcompany\BestcompanyApi\Tests;

use InvalidArgumentException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class ReviewsTest extends BaseTestCase
{
    function test_it_requires_api_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $api = new BestcompanyApi([
          'hostname' => $this->hostname
        ]);

        $response = $api->reviews()->all();
    }

    function test_it_requires_valid_api_key(): void
    {
        $api = new BestcompanyApi([
          'key' => 'asdfasdf',
          'hostname' => $this->hostname
        ]);

        $response = $api->reviews()->all();
        $this->assertEquals(401, $response->getResponse()->getStatusCode());
    }

    function test_all_reviews(): void
    {
        $api = new BestcompanyApi([
          'key' => $this->key,
          'hostname' => $this->hostname
        ]);

        $response = $api->reviews()->all();
        $this->assertEquals(200, $response->getStatusCode());
        $body = (string) $response->getBody();
        $json = json_decode($body);
        $this->assertObjectHasAttribute('current_page',$json);
    }

    function test_single_review(): void
    {
        $api = new BestcompanyApi([
          'key' => $this->key,
          'hostname' => $this->hostname
        ]);

        $response = $api->reviews()->getById(1);
        $this->assertEquals(200, $response->getStatusCode());
        $body = (string) $response->getBody();
        $json = json_decode($body);
        $this->assertObjectHasAttribute('id', $json);
        $this->assertObjectHasAttribute('live_version', $json);
        $this->assertObjectHasAttribute('reviewer', $json);
    }
}
