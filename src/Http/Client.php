<?php

namespace Bestcompany\BestcompanyApi\Http;

use InvalidArgumentException;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Client
{
    /** @var string */
    public $key;

    /** @var string */
    public $hostname;

    /** @var string */
    public $version;

    /** @var \GuzzleHttp\Client */
    public $client;

    public function __construct($config = [], $client = null, private $clientOptions = [], private $wrapResponse = true)
    {
      // Require explicit configuration - no env fallbacks
      $this->key = $config['key'] ?? null;
      $this->hostname = $config['hostname'] ?? null;
      $this->version = $config['version'] ?? null;

      if (is_null($client)) {
        $client = new GuzzleClient();
      }
      $this->client = $client;
    }

    /**
     * Send the request...
     *
     * @param string $method        The HTTP request verb
     * @param string $path          The BC API path
     * @param array  $options       An array of options to send with the request
     * @param string $query_string  A query string to send with the request
     *
     * @return Object
     */
    public function request($method, $path, array $options = [], $query_string = null)
    {
      if (empty($this->key)) {
        throw new InvalidArgumentException('You must provide an API key.');
      }

      $url = $this->generateUrl($path, $query_string);

      $options = array_merge($this->clientOptions, $options);

      $options['Accept'] = 'application/json';
      $options['headers']['Authorization'] = 'Bearer ' . $this->key;
      try {
        // This is simplistic for a response
        // probably want a custom response class
        // That way we could add useful methods.
        $response = $this->client->request($method, $url, $options);
        $jsonString = (string) $response->getBody();
        return json_decode($jsonString);
      } catch (ServerException $e) {
        throw $e;
      } catch (ClientException $e) {
        throw $e;
      }
    }

    protected function generateUrl($path, $query_string = null)
    {
      $formattedVersion = $this->version && $this->version !== '' ? $this->version.'/' : '';
      $url = $this->hostname.'/'.$formattedVersion.$path . '?';
      $query_params = [];

      $query_string .= $this->addQuery($query_string, http_build_query($query_params));

      return $url . $query_string;
    }

    /**
     * @param string $query_string the query string to send to the endpoint
     * @param string $addition     addition query string to send to the endpoint
     *
     * @return string
     */
    protected function addQuery($query_string, $addition)
    {
      $result = '';

      if (!empty($addition)) {
        if (empty($query_string)) {
          $result = $addition;
        } else {
          $result .= '&' . $addition;
        }
      }

      return $result;
    }
}
