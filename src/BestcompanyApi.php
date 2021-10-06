<?php

namespace Bestcompany\BestcompanyApi;

use Bestcompany\BestcompanyApi\Http\Client;
use Bestcompany\BestcompanyApi\Resources\Resource;

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
}
