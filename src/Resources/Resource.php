<?php

namespace Bestcompany\BestcompanyApi\Resources;

use Bestcompany\BestcompanyApi\Http\Client;

abstract class Resource
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Makin' a good old resource.
     *
     * @param  Client  $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }
}
