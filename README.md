# A fluent api around the quickpay api for Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/netbums/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/netbums/laravel-quickpay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mortenebak/laravel-quickpay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mortenebak/laravel-quickpay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mortenebak/laravel-quickpay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mortenebak/laravel-quickpay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mortenebak/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/mortenebak/laravel-quickpay)

This laravel package will help you utilize the Quickpay API Client, without knowing too much about the endpoints. It provides a fluent api for using the API. See examples below.

## Support me
[Consider supporting me by sponsoring my work](https://github.com/sponsors/mortenebak/)

## Installation

1. You can install the package via composer:

```bash
composer require netbums/laravel-quickpay
```

[//]: # (2. Add the Provider to your `config/app.php` providers array:)

[//]: # ()
[//]: # (```php)

[//]: # (// config/app.php)

[//]: # ('providers' => [)

[//]: # (    //...)

[//]: # (    Netbums\Quickpay\QuickpayServiceProvider::class,)

[//]: # (],)

[//]: # (```)

[//]: # (3. Add the facade to your `config/app.php` aliases array:)

[//]: # ()
[//]: # (```php)

[//]: # (// config/app.php)

[//]: # ('aliases' => [)

[//]: # (    //...)

[//]: # (    'Quickpay' => Netbums\Quickpay\Facades\Quickpay::class,)

[//]: # (],)

[//]: # (```)

2. Publish the config file with:

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

3. Add the environment variables to your `.env` file:

```bash
QUICKPAY_API_KEY=
QUICKPAY_LOGIN=
QUICKPAY_PASSWORD=
QUICKPAY_MERCHANT_ID=
```
---
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
// First create a basket with items
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

// Then create a payment with the basket, and a unique order id
$paymentData = new \Netbums\Quickpay\DataObjects\Payment(
    currency: 'DKK',
    order_id: '1234',
    basket:  $basket,
)

// Then create the payment
$createdPayment = \Netbums\Quickpay\Quickpay::api()->payments()->create(
    payment: $paymentData
)
```
After a payment is created you can create a payment link for it, and redirect the user to the payment link.

#### Update a payment
```php
```

#### Capture a payment
Capture a payment. This will capture the amount of the payment specified.
```php
$payment = Quickpay::api()->payments()->capture(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Refund a payment
Refund a payment. This will refund the amount of the payment specified.
```php
$payment = Quickpay::api()->payments()->refund(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Authorize a payment
Authorize a payment. This will reserve the amount on the card, but not capture it.
```php
$payment = Quickpay::api()->payments()->authorize(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Renew authorization of a payment
Renew the authorization of a payment. This will reserve the amount on the card, but not capture it.
```php
$payment = Quickpay::api()->payments()->renew(
    id: $paymentId,
);
```

#### Cancel a payment
Cancel a payment. This will cancel the payment, and release the reserved amount on the card.
```php
$payment = Quickpay::api()->payments()->cancel(
    id: $paymentId,
);
```

#### Create a payment link
Create a payment link for a payment. Optional parameters are: `language`, `continue_url`, `cancel_url`, `callback_url`:
```php
$paymentLinkData = new \Netbums\Quickpay\DataObjects\PaymentLink(
    id: $paymentId,
    amount: 100, // in smallest currency unit
    language: 'da',
    continue_url: 'https://example.com/continue',
    cancel_url: 'https://example.com/cancel',
    callback_url: 'https://example.com/callback',
);

$paymentLink = Quickpay::api()->payments()->createPaymentLink(
    paymentLink: $paymentLinkData,
);
```

#### Create a payment session
```php
$session = Quickpay::api()->payments()->session(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Create Fraud Report
Create a fraud report for a payment. Optional parameters are: `description`:
```php
$fraudReport = new \Netbums\Quickpay\Quickpay()->payments()->createFraudReport(
    id: $paymentId,
    description: 'Fraudulent payment',
);
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
