# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bestcompany/bestcompany-api.svg?style=flat-square)](https://packagist.org/packages/bestcompany/bestcompany-api)
[![Total Downloads](https://img.shields.io/packagist/dt/bestcompany/bestcompany-api.svg?style=flat-square)](https://packagist.org/packages/bestcompany/bestcompany-api)
![GitHub Actions](https://github.com/bestcompany/bestcompany-api/actions/workflows/main.yml/badge.svg)

This is a package to interact with the bestcompany api.

## Installation

You can install the package via composer:

```bash
composer require bestcompany/bestcompany-api
```

Then if using laravel publish your config file by running the command.

`php artisan vendor:publish --provider="Bestcompany\BestcompanyApi\BestcompanyApiServiceProvider" --tag="config"`

Add your api key to the .env using the key from the config file.

## Usage


```php
$api = new BestcompanyApi;

$api->reviews()->all();
```

If you discover any security related issues, please email cpope@bestcompany.com instead of using the issue tracker.

## Credits

-   [Cameron Pope](https://github.com/bestcompany)
-   [All Contributors](../../contributors)

## License

The Apache License 2. Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
