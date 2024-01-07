# A fluent api around the quickpay api for Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/netbums/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/netbums/laravel-quickpay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/netbums/laravel-quickpay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/netbums/laravel-quickpay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/netbums/laravel-quickpay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/netbums/laravel-quickpay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/netbums/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/netbums/laravel-quickpay)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

## Installation

You can install the package via composer:

```bash
composer require netbums/laravel-quickpay
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-quickpay-config"
```

This is the contents of the published config file:

```php
return [
    'api_key' => env('QUICKPAY_API_KEY'),
    'login' => env('QUICKPAY_LOGIN'),
    'password' => env('QUICKPAY_PASSWORD'),
    'merchant_id' => env('QUICKPAY_MERCHANT_ID'),
];
```

## Usage

```php

use \Netbums\Quickpay\Quickpay;

$payments = Quickpay::payments()->all();

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Morten Bak](https://github.com/mortenebak)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
