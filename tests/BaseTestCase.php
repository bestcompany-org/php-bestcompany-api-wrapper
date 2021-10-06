<?php

namespace Bestcompany\BestcompanyApi\Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected $key;
    protected $hostname;

    public function setUp(): void
    {
      parent::setUp();

      $envFile = dirname(__DIR__,1);
      $dotenv = Dotenv::createImmutable($envFile);
      $dotenv->safeLoad();

      $this->key = $_ENV['BC_API_KEY'];
      $this->hostname = $_ENV['BC_HOSTNAME'];
    }

}
