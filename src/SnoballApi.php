<?php

namespace Bestcompany\BestcompanyApi;

use Bestcompany\BestcompanyApi\Http\Client;
use Bestcompany\BestcompanyApi\Util\WebhookEvent;
use Bestcompany\BestcompanyApi\Resources\Resource;
use Bestcompany\BestcompanyApi\Exceptions\SignatureVerificationException;

class SnoballApi
{
    /**
     * @var Client
     */
    protected $client;

    /**
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
     * Automatically discovers resources from the SnoballApi resources directory.
     *
     * @param mixed $args
     */
    public function __call(string $name, $args): Resource
    {
        $resourceClass = 'Bestcompany\\BestcompanyApi\\Resources\\SnoballApi\\' . ucfirst($name);

        if (!class_exists($resourceClass)) {
            // Get available resources for a helpful error message
            $availableResources = $this->getAvailableResources();
            throw new \BadMethodCallException(
                "Resource '{$name}' is not available in SnoballApi. Available resources: " .
                implode(', ', $availableResources)
            );
        }

        return new $resourceClass($this->client, ...$args);
    }

    /**
     * Get list of available resources by scanning the SnoballApi resources directory.
     *
     * @return array
     */
    protected function getAvailableResources(): array
    {
        $resourcesPath = __DIR__ . '/Resources/SnoballApi';
        $resources = [];

        if (is_dir($resourcesPath)) {
            $files = scandir($resourcesPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $resourceName = lcfirst(pathinfo($file, PATHINFO_FILENAME));
                    $resources[] = $resourceName;
                }
            }
        }

        return $resources;
    }

    /**
     * Get the underlying HTTP client
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Create an instance of the service with an API key.
     *
     * @param array  $config        configuration array
     * @param Client $client        an Http client
     * @param array  $clientOptions options to be send with each request
     *
     * @return static
     */
    public static function create(array $config = [], Client $client = null, array $clientOptions = []): self
    {
        return new static($config, $client, $clientOptions);
    }

    /**
     * Handle Snoball webhook verification
     */
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
            try {
                return new WebhookEvent(
                    $payload['key'] ?? null,
                    $payload['event'] ?? null,
                    $payload['data'] ?? null,
                    $payload['created'] ?? null
                );
            } catch (\Throwable $e) {
                throw new \UnexpectedValueException('Payload Invalid', 422);
            }
        }
        throw new SignatureVerificationException('Signature Invalid', 400);
    }
}
