<?php

namespace Bestcompany\BestcompanyApi\Tests;

use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\Tests\BaseTestCase;
use Bestcompany\BestcompanyApi\Exceptions\SignatureVerificationException;
use Bestcompany\BestcompanyApi\Util\WebhookEvent;

class WebhookTest extends BaseTestCase
{
  private $payload;

  public function setUp(): void
  {
      $this->payload = array(
        'key' => '1a7de744-d27c-4e5c-bb8e-558fa22af450',
        'event' => 'rep-access-request.created',
        'data' =>
        array(
          'id' => 21,
          'company_id' => '284',
          'name' => "Y'shtola",
        ),
        'created' => 1635911154,
      );
  }

  function test_invalid_signature(): void
  {
    $this->expectException(SignatureVerificationException::class);
    $timestamp = time();
    $secret = 'bctestsignatures';
    $testSignature = $this->createSignatureHash($timestamp, $this->payload, 'invalidsecret', true);
    $signatureHeader = "t=$timestamp,signature=$testSignature,test=$testSignature";
    $event = BestcompanyApi::webhook($this->payload, $signatureHeader, $secret);
  }

  function test_invalid_timestamp(): void
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

  function test_invalid_payload(): void
  {
    $this->expectException('UnexpectedValueException');
    $this->expectExceptionMessage('Payload Invalid');
    $payload = [];
    $timestamp = time();
    $secret = 'bctestsignature';
    $testSignature = $this->createSignatureHash($timestamp, $payload, $secret);
    $signatureHeader = "t=$timestamp,signature=$testSignature,test=$testSignature";
    $event = BestcompanyApi::webhook($payload, $signatureHeader, $secret, true);
    $this->assertInstanceOf(WebhookEvent::class, $event);
    $this->assertEquals($payload, (array) $event);
  }

  function test_valid_webhook(): void
  {
    $timestamp = time();
    $secret = 'bctestsignature';
    $testSignature = $this->createSignatureHash($timestamp, $this->payload, $secret);
    $signatureHeader = "t=$timestamp,signature=$testSignature,test=$testSignature";
    $event = BestcompanyApi::webhook($this->payload, $signatureHeader, $secret, true);
    $this->assertInstanceOf(WebhookEvent::class, $event);
    $this->assertEquals($this->payload, (array) $event);
  }
  private function createSignatureHash(int $timestamp, Array $payload, string $secret)
  {
    $signedPayload = (string) $timestamp . json_encode($payload);
    return hash_hmac("sha256", $signedPayload, $secret);
  }
}
