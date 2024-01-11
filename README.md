# A fluent api around the quickpay api for Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/netbums/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/netbums/laravel-quickpay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/netbums/laravel-quickpay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/netbums/laravel-quickpay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/netbums/laravel-quickpay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/netbums/laravel-quickpay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/netbums/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/netbums/laravel-quickpay)

This laravel package will help you utilize the Quickpay API Client, without know too much about the endpoints. It provides a fluent api for using the API.

## Support us
[Consider sponsoring my work](https://github.com/sponsors/mortenebak/)

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
// config/quickpay.php
return [
    'api_key' => env('QUICKPAY_API_KEY'),
    'login' => env('QUICKPAY_LOGIN'),
    'password' => env('QUICKPAY_PASSWORD'),
    'merchant_id' => env('QUICKPAY_MERCHANT_ID'),
];
```

## Usage
The following examples uses this:

```php
use \Netbums\Quickpay\Quickpay;
```

### Payments

#### Get all payments

```php
$payments = Quickpay::api()->payments()->all();
```

#### Get a payment
Getting a single payment by id
```php
$payment = Quickpay::api()->payments()->find($paymentId);
```

#### Create a payment
```php
$basket = new \Netbums\Quickpay\DataObjects\Basket(
    items: [
        new \Netbums\Quickpay\DataObjects\BasketItem(
            qty: 1,
            item_name: 'Test item',
            item_no: 'sku-1234',
            item_price: 100, // in smallest currency unit
            vat_rate: 25,
        )
    ]
)
$paymentData = new \Netbums\Quickpay\DataObjects\Payment(
    currency: 'DKK',
    order_id: '1234',
    basket:  $basket,
)

$createdPayment = \Netbums\Quickpay\Quickpay::api()->payments()->create(
    payment: $paymentData
)
```

#### Update a payment
```php
```

#### Capture a payment
```php
```

#### Refund a payment
```php
```

#### Authorize a payment
```php
```

#### Renew authorization of a payment
```php
```

#### Cancel a payment
```php
```

#### Create a payment link
```php
```

#### Create a payment session
```php
```

#### 


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
