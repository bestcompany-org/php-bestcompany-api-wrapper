<?php

namespace Bestcompany\BestcompanyApi\Tests\V1;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class ReviewsTest extends BaseTestCase
{
    function test_it_requires_api_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $api = new BestcompanyApi([
          'hostname' => $this->hostname,
          'version' => 'v1'
        ]);

        $response = $api->reviews()->all();
    }

    function test_it_requires_valid_api_key(): void
    {
        $this->expectException(ClientException::class);

        $api = new BestcompanyApi([
          'key' => 'asdfasdf',
          'hostname' => $this->hostname,
          'version' => 'v1'
        ]);

        $response = $api->reviews()->all();
        $this->assertEquals(401, $response->getResponse()->getStatusCode());
    }

    function test_all_reviews(): void
    {
        $api = new BestcompanyApi([
          'key' => $this->key,
          'hostname' => $this->hostname,
          'version' => 'v1'
        ]);

        $data = $api->reviews()->all();
        $this->assertObjectHasAttribute('data', $data);
        $this->assertObjectHasAttribute('meta', $data);
    }

    function test_single_review(): void
    {
        $api = new BestcompanyApi([
          'key' => $this->key,
          'hostname' => $this->hostname,
          'version' => 'v1'
        ]);

        $data = $api->reviews()->getById(1);
        $this->assertObjectHasAttribute('id', $data);
        $this->assertObjectHasAttribute('live_version', $data);
        $this->assertObjectHasAttribute('reviewer', $data);
    }
}
