<?php

namespace Bestcompany\BestcompanyApi\Tests\V1;

use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;

class CompanyReviewListsTest extends BaseTestCase
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

  function test_all_company_review_lists(): void
  {
    $this->markTestSkipped('company-campaigns endpoint removed from API');
    
    $api = new BestcompanyApi([
      'key' => $this->key,
      'hostname' => $this->hostname,
      'version' => 'v1'
    ]);

    $data = $api->companyReviewLists()->all();
    $this->assertObjectHasProperty('data', $data);
    $this->assertObjectHasProperty('meta', $data);
  }
}
