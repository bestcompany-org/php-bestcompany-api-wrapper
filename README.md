# Bestcompany & Snoball API Wrapper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bestcompany/bestcompany-api.svg?style=flat-square)](https://packagist.org/packages/bestcompany/bestcompany-api)
[![Total Downloads](https://img.shields.io/packagist/dt/bestcompany/bestcompany-api.svg?style=flat-square)](https://packagist.org/packages/bestcompany/bestcompany-api)
![GitHub Actions](https://github.com/bestcompany/bestcompany-api/actions/workflows/main.yml/badge.svg)

This package provides Laravel-compatible API wrappers for both Bestcompany and Snoball services, with automatic resource separation and type-safe dependency injection.

## Installation

You can install the package via composer:

```bash
composer require bestcompany/bestcompany-api
```

Then if using laravel publish your config file by running the command.

`php artisan vendor:publish --provider="Bestcompany\BestcompanyApi\BestcompanyApiServiceProvider" --tag="config"`

Add your api key to the .env using the key from the config file.

## Usage

### Separate API Clients

This package provides separate API clients for different services:

- **BestcompanyApi**: Main API for companies, reviews, and general operations
- **SnoballApi**: Dedicated API for referral-related operations

#### Using BestcompanyApi

```php
use Bestcompany\BestcompanyApi\BestcompanyApi;

$api = BestcompanyApi::create([
    'key' => 'your_api_key',
    'hostname' => 'https://api.bestcompany.com/api',
    'version' => 'v1'
]);

// Company operations
$companies = $api->companies()->all();
$company = $api->companies()->get(123);

// Review operations
$reviews = $api->reviews()->all();
$review = $api->reviews()->get(456);

// Other available resources
$api->verticals()->all();
$api->factSheets()->all();
$api->companyReviewLists()->all();
```

#### Using SnoballApi

```php
use Bestcompany\BestcompanyApi\SnoballApi;

$snoballApi = SnoballApi::create([
    'key' => 'your_snoball_api_key',
    'hostname' => 'https://api.snoball.com/api',
    'version' => 'v1'
]);

// Referral operations
$referral = $snoballApi->referralRequest()->create([
    'user_id' => 456,
    'company_id' => 789,
    'referral_type' => 'standard'
]);

$salesRep = $snoballApi->salesRepReferral()->all();
```

### Laravel Usage with Dependency Injection

```php
use Bestcompany\BestcompanyApi\BestcompanyApi;
use Bestcompany\BestcompanyApi\SnoballApi;

class CompanyController extends Controller
{
    public function __construct(
        private BestcompanyApi $bestcompanyApi,
        private SnoballApi $snoballApi
    ) {}

    public function getCompanies()
    {
        $companies = $this->bestcompanyApi->companies()->all();
        return response()->json($companies);
    }

    public function createReferral(Request $request)
    {
        $referral = $this->snoballApi->referralRequest()->create($request->all());
        return response()->json($referral);
    }
}
```

### Available Resources

#### BestcompanyApi Resources
- `bsCompany()` - Company management operations
- `bsFeatureAdoption()` - Feature adoption tracking
- `bsReviewActions()` - Review action management
- `bsUserNotifications()` - User notification system
- `cache()` - Caching operations
- `companies()` - Company data and operations
- `companyPromotionalUrls()` - Promotional URL management
- `companyReviewLists()` - Company review list management
- `emails()` - Email operations
- `factSheetQuestions()` - Fact sheet question management
- `factSheets()` - Fact sheet operations
- `fieldReps()` - Field representative management
- `reviewBsUserFavorites()` - User favorite reviews
- `reviewMessage()` - Review messaging system
- `reviews()` - Review data and operations
- `verticals()` - Industry vertical management

#### SnoballApi Resources
- `referralRequest()` - Referral request management
- `repConversation()` - Rep conversation management
- `salesRepReferral()` - Sales representative referral operations

### Configuration

### Configuration

The package requires explicit configuration to be passed to each API client. The Laravel service provider handles this automatically using environment variables and config files.

**Environment Variables:**
```env
# Bestcompany API
BC_API_KEY=your_bestcompany_api_key
BC_HOSTNAME=https://api.bestcompany.com/api
BC_API_VERSION=v1

# Snoball API (for referral requests)
SNOBALL_API_KEY=your_snoball_api_key
SNOBALL_HOSTNAME=https://api.snoball.com/api
SNOBALL_API_VERSION=v1
```

**Laravel Configuration:**
After publishing the config files, you can configure these in `config/bestcompany-api.php` and `config/snoball.php`:

```php
// config/bestcompany-api.php
return [
    'api_key' => env('BC_API_KEY', null),
    'hostname' => env('BC_HOSTNAME', 'https://api.bestcompany.com/api'),
    'version' => env('BC_API_VERSION', 'v1'),
];

// config/snoball.php
return [
    'api_key' => env('SNOBALL_API_KEY', null),
    'hostname' => env('SNOBALL_HOSTNAME', 'https://api.snoball.com/api'),
    'version' => env('SNOBALL_API_VERSION', 'v1'),
];
```

**Manual Configuration:**
When creating API instances manually (outside of Laravel), you must provide the configuration explicitly:

```php
// Required configuration for BestcompanyApi
$api = BestcompanyApi::create([
    'key' => 'your_api_key',
    'hostname' => 'https://api.bestcompany.com/api',
    'version' => 'v1'
]);

// Required configuration for SnoballApi
$snoballApi = SnoballApi::create([
    'key' => 'your_snoball_key',
    'hostname' => 'https://api.snoball.com/api',
    'version' => 'v1'
]);
```

> **Note**: The API clients no longer fall back to environment variables automatically. Configuration must be explicitly provided either through the Laravel service provider or when creating instances manually.

### Laravel Facades (Optional)

You can also use Laravel facades for easier access:

```php
// In your config/app.php aliases array:
'aliases' => [
    'BestcompanyApi' => Bestcompany\BestcompanyApi\BestcompanyApiFacade::class,
    'SnoballApi' => Bestcompany\BestcompanyApi\SnoballApiFacade::class,
]

// Then use directly:
use BestcompanyApi;
use SnoballApi;

$companies = BestcompanyApi::companies()->all();
$referrals = SnoballApi::referralRequest()->all();
```

### Error Handling

The package automatically prevents cross-API resource access:

```php
// This will throw a BadMethodCallException:
$bestcompanyApi->referralRequest(); // ❌ Not available in BestcompanyApi

// This will throw a BadMethodCallException:
$snoballApi->companies(); // ❌ Not available in SnoballApi
```

The error messages will show you which resources are available for each API client.

If you discover any security related issues, please email technology@bestcompany.com instead of using the issue tracker.

## Credits

-   Created by [Cameron Pope](https://github.com/campope)
-   Maintained by [Braden James](https://github.com/Censin)
-   [All Contributors](../../contributors)

## License

The Apache License 2. Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
