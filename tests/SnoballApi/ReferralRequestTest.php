<?php

namespace Bestcompany\BestcompanyApi\Tests\SnoballApi;

use Bestcompany\BestcompanyApi\Enums\SnoballApiErrorCode;
use Bestcompany\BestcompanyApi\Exceptions\SnoballApiException;
use Bestcompany\BestcompanyApi\Http\Client;
use Bestcompany\BestcompanyApi\Resources\SnoballApi\ReferralRequest;
use Bestcompany\BestcompanyApi\SnoballApi;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;

class ReferralRequestTest extends TestCase
{
    protected function tearDown(): void
    {
        Container::setInstance(null);

        parent::tearDown();
    }

    /**
     * Build a SnoballApi whose HTTP client returns the given queued responses,
     * and bind it into the container so the resource's app(SnoballApi::class)
     * lookup resolves it (mirroring how consumers wire it in production).
     */
    private function apiReturning(Response ...$responses): SnoballApi
    {
        $guzzle = new GuzzleClient([
            'handler' => HandlerStack::create(new MockHandler($responses)),
        ]);

        $client = new Client(['key' => 'test-api-key', 'hostname' => 'https://example.com'], $guzzle);
        $api = new SnoballApi([], $client);

        Container::getInstance()->instance(SnoballApi::class, $api);

        return $api;
    }

    public function test_resource_is_accessible(): void
    {
        $resource = $this->apiReturning()->referralRequest();

        $this->assertInstanceOf(ReferralRequest::class, $resource);
    }

    public function test_it_returns_the_decoded_body_on_success(): void
    {
        $api = $this->apiReturning(new Response(201, [], json_encode([
            'message' => 'SUCCESS: Referral request created and sent.',
            'referral_request_id' => 42,
            'url' => 'https://example.com/r/abc',
        ])));

        $result = $api->referralRequest()->create(['bs_company_id' => 1]);

        $this->assertSame(42, $result->referral_request_id);
    }

    public function test_it_parses_a_user_safe_structured_error(): void
    {
        $api = $this->apiReturning(new Response(403, [], json_encode([
            'message' => 'FAILURE: Referral Request annual limit reached.',
            'error' => [
                'code' => 'REFERRAL_LIMIT_REACHED',
                'display_message' => 'This company has reached its annual referral limit.',
                'user_safe' => true,
            ],
        ])));

        try {
            $api->referralRequest()->create(['bs_company_id' => 1]);
            $this->fail('Expected SnoballApiException was not thrown.');
        } catch (SnoballApiException $e) {
            $this->assertSame(403, $e->statusCode());
            $this->assertSame(SnoballApiErrorCode::ReferralLimitReached, $e->errorCode());
            $this->assertTrue($e->isUserSafe());
            $this->assertSame('This company has reached its annual referral limit.', $e->displayMessage());
            $this->assertFalse($e->hasFieldErrors());
        }
    }

    public function test_it_exposes_field_errors_from_a_validation_response(): void
    {
        $api = $this->apiReturning(new Response(422, [], json_encode([
            'message' => 'FAILURE: Validation failed.',
            'error' => ['code' => 'VALIDATION_FAILED', 'user_safe' => true],
            'errors' => [
                'number' => ['Phone number must be exactly 12 characters (including country code).'],
            ],
        ])));

        try {
            $api->referralRequest()->create(['bs_company_id' => 1]);
            $this->fail('Expected SnoballApiException was not thrown.');
        } catch (SnoballApiException $e) {
            $this->assertSame(SnoballApiErrorCode::ValidationFailed, $e->errorCode());
            $this->assertTrue($e->hasFieldErrors());
            $this->assertArrayHasKey('number', $e->fieldErrors());
            $this->assertSame(
                ['Phone number must be exactly 12 characters (including country code).'],
                $e->fieldErrors()['number'],
            );
        }
    }

    public function test_a_not_user_safe_error_hides_its_display_message(): void
    {
        $api = $this->apiReturning(new Response(422, [], json_encode([
            'message' => 'FAILURE: Unable to determine sales rep or user.',
            'error' => [
                'code' => 'REP_RESOLUTION_FAILED',
                'display_message' => 'internal: rep resolution failed',
                'user_safe' => false,
            ],
        ])));

        try {
            $api->referralRequest()->create(['bs_company_id' => 1]);
            $this->fail('Expected SnoballApiException was not thrown.');
        } catch (SnoballApiException $e) {
            $this->assertSame(SnoballApiErrorCode::RepResolutionFailed, $e->errorCode());
            $this->assertFalse($e->isUserSafe());
            $this->assertNull($e->displayMessage());
        }
    }

    public function test_a_legacy_error_without_the_envelope_degrades_gracefully(): void
    {
        $api = $this->apiReturning(new Response(500, [], json_encode([
            'message' => 'FAILURE: An unexpected error occurred while processing your request.',
        ])));

        try {
            $api->referralRequest()->create(['bs_company_id' => 1]);
            $this->fail('Expected SnoballApiException was not thrown.');
        } catch (SnoballApiException $e) {
            $this->assertSame(500, $e->statusCode());
            $this->assertNull($e->errorCode());
            $this->assertFalse($e->isUserSafe());
            $this->assertNull($e->displayMessage());
            $this->assertStringContainsString('unexpected error', $e->getMessage());
        }
    }

    public function test_an_unknown_error_code_resolves_to_null(): void
    {
        $api = $this->apiReturning(new Response(400, [], json_encode([
            'message' => 'FAILURE: something new',
            'error' => ['code' => 'SOME_FUTURE_CODE', 'user_safe' => false],
        ])));

        try {
            $api->referralRequest()->create(['bs_company_id' => 1]);
            $this->fail('Expected SnoballApiException was not thrown.');
        } catch (SnoballApiException $e) {
            $this->assertNull($e->errorCode());
            $this->assertFalse($e->isUserSafe());
        }
    }
}
