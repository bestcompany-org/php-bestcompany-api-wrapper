<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Snoball API Key
    |--------------------------------------------------------------------------
    |
    | The Snoball API key to use for authentication requests.
    |
    */

  'api_key' => env('SNOBALL_API_KEY', null),

  /*
    |--------------------------------------------------------------------------
    | Snoball Hostname
    |--------------------------------------------------------------------------
    |
    | The base URL for the Snoball API service.
    |
    */

  'hostname' => env('SNOBALL_HOSTNAME', 'https://api.snoball.com/api'),

  /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    | The API version to use for Snoball requests.
    |
    */

  'version' => env('SNOBALL_API_VERSION', null),

];
