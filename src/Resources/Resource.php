<?php

namespace Bestcompany\BestcompanyApi\Resources;

abstract class Resource
{
  /**
   * @var \Bestcompany\BestcompanyApi\Http\Client
   */
  protected $client;

  /**
   * Makin' a good old resource.
   *
   * @param \Bestcompany\BestcompanyApi\Http\Client $client
   */
  public function __construct($client)
  {
    $this->client = $client;
  }
}
