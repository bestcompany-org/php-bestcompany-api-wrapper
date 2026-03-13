<?php

namespace Bestcompany\BestcompanyApi\Tests\SnoballApi;

use Bestcompany\BestcompanyApi\Resources\SnoballApi\ReviewSubmitted;
use Bestcompany\BestcompanyApi\SnoballApi;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ReviewSubmittedTest extends TestCase
{
    public function test_it_requires_api_key(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $api = new SnoballApi([
            'hostname' => 'https://example.com',
        ]);

        $api->reviewSubmitted()->create(['review_id' => 1]);
    }

    public function test_resource_is_accessible(): void
    {
        $api = new SnoballApi([
            'key' => 'test-api-key',
            'hostname' => 'https://example.com',
        ]);

        $resource = $api->reviewSubmitted();

        $this->assertInstanceOf(ReviewSubmitted::class, $resource);
    }

    public function test_resource_not_found_throws_exception(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $api = new SnoballApi([
            'key' => 'test-api-key',
            'hostname' => 'https://example.com',
        ]);

        $api->nonExistentResource();
    }
}
