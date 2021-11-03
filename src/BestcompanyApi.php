<?php

namespace Bestcompany\BestcompanyApi;

use Bestcompany\BestcompanyApi\Http\Client;
use Bestcompany\BestcompanyApi\Util\WebhookEvent;
use Bestcompany\BestcompanyApi\Resources\Resource;
use Bestcompany\BestcompanyApi\Exceptions\SignatureVerificationException;

class BestcompanyApi
{
    /**
     * @var Client
     */
    protected $client;

    /**
    *
    * @param array  $config
    * @param Client $client
    * @param array  $clientOptions options to be send with each request
    */
    public function __construct(array $config = [], Client $client = null, array $clientOptions = [])
    {
      if (is_null($client)) {
        $client = new Client($config, null, $clientOptions);
      }
      $this->client = $client;
    }

    /**
     * Return an instance of a Resource based on the method called.
     *
     * @param mixed $args
     */
    public function __call(string $name, $args): Resource
    {
      $resource = 'Bestcompany\\BestcompanyApi\\Resources\\' . ucfirst($name);
      return new $resource($this->client, ...$args);
    }

    /**
     * Create an instance of the service with an API key.
     *
     * @param string $api_key       bc API key
     * @param Client $client        an Http client
     * @param array  $clientOptions options to be send with each request
     *
     * @return static
     */
    public static function create(array $config = [], Client $client = null, array $clientOptions = []): self
    {
      return new static($config, $client, $clientOptions);
    }

    public static function webhook(array $payload, string $signatureHeader, string $secret, bool $test = false)
    {
      $headers = headerStringToArray($signatureHeader);
      $now = time();
      $timestamp = $headers['t'];
      $timestampDifferenceInMinutes = abs($now - intval($timestamp)) / 60;
      if ($timestampDifferenceInMinutes > 5) {
        throw new \UnexpectedValueException('Timestamp Invalid', 422);
      }
      $signature = $test ? $headers['test'] : $headers['signature'];
      $signedPayload = (string) $timestamp . json_encode($payload);
      $generatedSignature = hash_hmac("sha256", $signedPayload, $secret);
      if ($signature === $generatedSignature) {
        $payload['lol'] = 'rofl';
        try {
          return new WebhookEvent($payload['key'], $payload['event'], $payload['data'], $payload['created']);
        } catch (\Throwable $e) {
          throw new \UnexpectedValueException('Payload Invalid', 422);
        }
      }
      throw new SignatureVerificationException('Signature Invalid', 400);
    }
}
