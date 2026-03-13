<?php

namespace Bestcompany\BestcompanyApi\Tests;

use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Exceptions\SignatureVerificationException;
use Bestcompany\BestcompanyApi\Util\WebhookEvent;
use PHPUnit\Framework\TestCase;

class WebhookTest extends TestCase
{
    private $payload;

    protected function setUp(): void
    {
        $this->payload = [
            'key' => '1a7de744-d27c-4e5c-bb8e-558fa22af450',
            'event' => 'rep-access-request.created',
            'data' => [
                'id' => 21,
                'company_id' => '284',
                'name' => "Y'shtola",
            ],
            'created' => 1635911154,
        ];
    }

    public function test_invalid_signature(): void
    {
        $this->expectException(SignatureVerificationException::class);
        $timestamp = time();
        $secret = 'bctestsignatures';
        $testSignature = $this->createSignatureHash($timestamp, $this->payload, 'invalidsecret', true);
        $signatureHeader = "t=$timestamp,signature=$testSignature,test=$testSignature";
        $event = BestcompanyApi::webhook($this->payload, $signatureHeader, $secret);
    }

    public function test_invalid_timestamp(): void
    {
        $this->expectException('UnexpectedValueException');
        $this->expectExceptionMessage('Timestamp Invalid');
        $timestamp = time() - (30 * 60);
        $secret = 'bctestsignature';
        $testSignature = $this->createSignatureHash($timestamp, $this->payload, $secret);
        $signatureHeader = "t=$timestamp,signature=$testSignature,test=$testSignature";
        $event = BestcompanyApi::webhook($this->payload, $signatureHeader, $secret, true);
        $this->assertEquals($this->payload, $event);
    }

    public function test_invalid_payload(): void
    {
        $payload = [];
        $timestamp = time();
        $secret = 'bctestsignature';
        $testSignature = $this->createSignatureHash($timestamp, $payload, $secret);
        $signatureHeader = "t=$timestamp,signature=$testSignature,test=$testSignature";
        try {
            BestcompanyApi::webhook($payload, $signatureHeader, $secret, true);
        } catch (\Throwable $th) {
            $this->assertStringContainsString('Payload Invalid', $th->getMessage());
        }
    }

    public function test_valid_webhook(): void
    {
        $timestamp = time();
        $secret = 'bctestsignature';
        $testSignature = $this->createSignatureHash($timestamp, $this->payload, $secret);
        $signatureHeader = "t=$timestamp,signature=$testSignature,test=$testSignature";
        $event = BestcompanyApi::webhook($this->payload, $signatureHeader, $secret, true);
        $this->assertInstanceOf(WebhookEvent::class, $event);
        $this->assertEquals($this->payload, (array) $event);
    }

    private function createSignatureHash(int $timestamp, array $payload, string $secret)
    {
        $signedPayload = (string) $timestamp.json_encode($payload);

        return hash_hmac('sha256', $signedPayload, $secret);
    }
}
