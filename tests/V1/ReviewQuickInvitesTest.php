<?php

namespace Bestcompany\BestcompanyApi\Tests\V1;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class ReviewQuickInvitesTest extends BaseTestCase
{
    function test_it_requires_api_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $api = new BestcompanyApi([
            'hostname' => $this->hostname,
            'version' => 'v1'
        ]);

        $response = $api->reviewQuickInvites()->all();
    }

    function test_it_requires_valid_api_key(): void
    {
        $this->expectException(ClientException::class);

        $api = new BestcompanyApi([
            'key' => 'asdfasdf',
            'hostname' => $this->hostname,
            'version' => 'v1'
        ]);

        $response = $api->reviewQuickInvites()->all();
        $this->assertEquals(401, $response->getResponse()->getStatusCode());
    }

    function test_all_review_quick_invite_requests(): void
    {
        $api = new BestcompanyApi([
            'key' => $this->key,
            'hostname' => $this->hostname,
            'version' => 'v1'
        ]);

        $data = $api->reviewQuickInvites()->all();
        $this->assertObjectHasAttribute('data', $data);
    }
}
