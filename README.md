# A fluent api around the quickpay api for Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/netbums/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/netbums/laravel-quickpay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mortenebak/laravel-quickpay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mortenebak/laravel-quickpay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![PHPStan](https://img.shields.io/github/actions/workflow/status/mortenebak/laravel-quickpay/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/mortenebak/laravel-quickpay/actions?query=workflow%3APHPStan+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mortenebak/laravel-quickpay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mortenebak/laravel-quickpay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/netbums/laravel-quickpay.svg?style=flat-square)](https://packagist.org/packages/netbums/laravel-quickpay)
 
This laravel package will help you utilize the Quickpay API Client, without knowing too much about the endpoints. It provides a fluent api for using the API. See examples below.

## Support me
[Consider supporting me by sponsoring my work](https://github.com/sponsors/mortenebak/)

## Installation

1. You can install the package via composer:

```bash
composer require netbums/laravel-quickpay
```

2. Publish the config file with:

```bash
php artisan quickpay:install
```
The service provider and the `Quickpay` facade are registered automatically. The config is merged from the package, so publishing it is only needed if you want to change it.

This is the contents of the published config file:

```php
// config/quickpay.php
return [
    'api_key' => env('QUICKPAY_API_KEY'),
    'login' => env('QUICKPAY_LOGIN'),
    'password' => env('QUICKPAY_PASSWORD'),
    'merchant_id' => env('QUICKPAY_MERCHANT_ID'),
    'private_key' => env('QUICKPAY_PRIVATE_KEY'),
];
```

3. Add the environment variables to your `.env` file:

```bash
QUICKPAY_API_KEY=
```
And alternatively, you can add the following environment variables to your `.env` file instead of the `QUICKPAY_API_KEY`:

```bash
QUICKPAY_LOGIN=
QUICKPAY_PASSWORD=
QUICKPAY_MERCHANT_ID=
```

To verify callbacks, add the private key of your Quickpay account (Settings > Integration in the Quickpay manager):

```bash
QUICKPAY_PRIVATE_KEY=
```

## Requirements

PHP 8.3 or newer and Laravel 12 or 13.

---
## Usage

### Payments

#### Get all payments

```php
use \Netbums\Quickpay\Facades\Quickpay;

$payments = Quickpay::payments()->all();
```

#### Get a payment
Getting a single payment by id
```php
use \Netbums\Quickpay\Facades\Quickpay;

$payment = Quickpay::payments()->find($paymentId);
```

#### Create a payment
First create a basket with items, and then create a payment with the basket and a unique order id.
```php

use \Netbums\Quickpay\DataObjects\Basket;
use \Netbums\Quickpay\DataObjects\BasketItem;
use \Netbums\Quickpay\DataObjects\Payment;
use \Netbums\Quickpay\Facades\Quickpay;

$basket = new Basket(
    items: [
        new BasketItem(
            qty: 1,
            item_name: 'Test item',
            item_no: 'sku-1234',
            item_price: 100, // in smallest currency unit
            vat_rate: 0.25, // 25%
        )
    ]
);

$paymentData = new Payment(
    currency: 'DKK',
    order_id: '1234',
    basket:  $basket,
);


$createdPayment = Quickpay::payments()->create(
    payment: $paymentData
);
```
After a payment is created you can create a payment link for it, and redirect the user to the payment link.

#### Create a payment link
```php
use \Netbums\Quickpay\Facades\Quickpay;
use \Netbums\Quickpay\DataObjects\PaymentLink;

$paymentLinkData = new PaymentLink(
    id: $createdPayment['id'], 
    amount: 100
);

$paymentLink = Quickpay::payments()->createLink($paymentLinkData);
```
This will return a URL, that you can redirect the user to.

#### Capture a payment
Capture a payment. This will capture the amount of the payment specified.
```php
use \Netbums\Quickpay\Facades\Quickpay;

$payment = Quickpay::payments()->capture(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Refund a payment
Refund a payment. This will refund the amount of the payment specified.
```php
use \Netbums\Quickpay\Facades\Quickpay;

$payment = Quickpay::payments()->refund(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Authorize a payment
Authorize a payment. This will reserve the amount on the card, but not capture it.
```php
use \Netbums\Quickpay\Facades\Quickpay;

$payment = Quickpay::payments()->authorize(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Renew authorization of a payment
Renew the authorization of a payment. This will reserve the amount on the card, but not capture it.
```php
use \Netbums\Quickpay\Facades\Quickpay;

$payment = Quickpay::payments()->renew(
    id: $paymentId,
);
```

#### Cancel a payment
Cancel a payment. This will cancel the payment, and release the reserved amount on the card.
```php
use \Netbums\Quickpay\Facades\Quickpay;

$payment = Quickpay::payments()->cancel(
    id: $paymentId,
);
```

#### Create a payment link
Create a payment link for a payment. Optional parameters are: `language`, `continue_url`, `cancel_url`, `callback_url`:
```php
use \Netbums\Quickpay\Facades\Quickpay;
use \Netbums\Quickpay\DataObjects\PaymentLink;

$paymentLinkData = new PaymentLink(
    id: $paymentId,
    amount: 100, // in smallest currency unit
    language: 'da',
    continue_url: 'https://example.com/continue',
    cancel_url: 'https://example.com/cancel',
    callback_url: 'https://example.com/callback',
);

$paymentLink = Quickpay::payments()->createLink(
    paymentLink: $paymentLinkData,
);
```

#### Create a payment session
```php
use \Netbums\Quickpay\Facades\Quickpay;

$session = Quickpay::payments()->createPaymentSession(
    id: $paymentId,
    amount: 100, // in smallest currency unit
);
```

#### Create Fraud Report
Create a fraud report for a payment. Optional parameters are: `description`:
```php
use \Netbums\Quickpay\Facades\Quickpay;

$fraudReport = Quickpay::payments()->createFraudConfirmationReport(
    id: $paymentId,
    description: 'Fraudulent payment',
);
```

## Subscriptions

The `Quickpay::subscriptions()` facade provides a fluent API for interacting with Quickpay Subscription endpoints.

#### Get all subscriptions

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptions = Quickpay::subscriptions()->all();
```

#### Get a subscription

Get a single subscription by id.

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptionId = 'your_subscription_id';
$subscription = Quickpay::subscriptions()->find($subscriptionId);
```

#### Create a subscription link

Create a payment link for a subscription. Requires a `SubscriptionLink` DataObject.

```php
use \Netbums\Quickpay\Facades\Quickpay;
use \Netbums\Quickpay\DataObjects\SubscriptionLink;

$subscriptionLinkData = new SubscriptionLink(
    id: $createdSubscription['id'],
    amount: 100, // in smallest currency unit
    language: 'en',
    continue_url: 'https://example.com/continue',
    cancel_url: 'https://example.com/cancel',
    callback_url: 'https://example.com/callback' // API
);

$subscriptionLink = Quickpay::subscriptions()->createSubscriptionLink($subscriptionLinkData);
```

#### Delete a subscription payment link

Delete the payment link for a subscription.

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptionId = 'your_subscription_id';
Quickpay::subscriptions()->deletePaymentLink($subscriptionId);
```

#### Create a subscription

Create a new subscription. Requires a `Subscription` DataObject.

```php
use \Netbums\Quickpay\Facades\Quickpay;
use \Netbums\Quickpay\DataObjects\Subscription;

$subscriptionData = new Subscription(
    currency: 'DKK',
    order_id: 'order_'.uniqid(),
    description: 'Subscription description',
);

$createdSubscription = Quickpay::subscriptions()->create($subscriptionData);
```

#### Update a subscription

Update a subscription. Requires the subscription ID and an array of data.

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptionId = 'your_subscription_id';
$updateData = [
    'state' => 'active',
    // ... other update properties
];
$updatedSubscription = Quickpay::subscriptions()->update($subscriptionId, $updateData);
```

#### Authorize a subscription

Authorize a subscription.

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptionId = 'your_subscription_id';
$authorizedSubscription = Quickpay::subscriptions()->authorize($subscriptionId);
```

#### Cancel a subscription

Cancel a subscription.

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptionId = 'your_subscription_id';
$canceledSubscription = Quickpay::subscriptions()->cancel($subscriptionId);
```

#### Create a recurring payment

Create a recurring payment for a subscription.

```php
use \Netbums\Quickpay\Facades\Quickpay;
use \Netbums\Quickpay\DataObjects\SubscriptionRecurring;

$subscriptionRecurringData = new SubscriptionRecurring(
    id: $subscriptionId,
    order_id: 'order_'.uniqid(),
    amount: 100, // in smallest currency unit
    auto_capture: true, // optional
);

$recurringPayment = Quickpay::subscriptions()->createRecurring($subscriptionRecurringData);
```

#### Create a fraud report

Create a fraud report for a subscription.

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptionId = 'your_subscription_id';
$fraudReport = Quickpay::subscriptions()->fraudReport($subscriptionId);
```

#### Get subscription payments

Get payments associated with a subscription.

```php
use \Netbums\Quickpay\Facades\Quickpay;

$subscriptionId = 'your_subscription_id';
$payments = Quickpay::subscriptions()->getPayments($subscriptionId);
```

## Callbacks

Quickpay signs every callback with the private key of your account and sends the signature in the `Quickpay-Checksum-Sha256` header. Verify it before you trust the payload:

```php
use Illuminate\Http\Request;
use \Netbums\Quickpay\Facades\Quickpay;

public function __invoke(Request $request)
{
    abort_unless(Quickpay::callbacks()->isValidRequest($request), 403);

    $payment = $request->json()->all();

    // ...
}
```

If you have the raw body and checksum at hand, use `Quickpay::callbacks()->isValid($body, $checksum)`. Remember to exclude the callback route from CSRF protection.

## Test mode

When your application runs in the `production` environment, a response for a transaction made with a test card (`test_mode` is `true`) throws `Netbums\Quickpay\Exceptions\CardNotAccepted`, wrapped in the exception of the operation you called. In every other environment test transactions are returned as usual.

## Exception Handling

Every exception thrown by the package extends `Netbums\Quickpay\Exceptions\QuickpayException`, so you can catch that to handle them all. The original exception is available through `getPrevious()`.

Dedicated exception classes are provided for handling errors during payment (`Netbums\Quickpay\Exceptions\Payments`) and subscription (`Netbums\Quickpay\Exceptions\Subscriptions`) operations. The subscription exceptions are:

- `FetchSubscriptionFailed`
- `FetchSubscriptionsFailed`
- `CreateRecurringFailed`
- `CreateSubscriptionFailed`
- `CreateSubscriptionLinkFailed`
- `DeletePaymentLinkFailed`
- `UpdateSubscriptionFailed`
- `AuthorizeSubscriptionFailed`
- `CancelSubscriptionFailed`
- `FraudReportSubscriptionFailed`
- `GetSubscriptionPaymentsFailed`

You should wrap your Quickpay calls in try-catch blocks to handle these specific exceptions.

## Testing

```bash
composer test
composer analyse
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Morten Bak](https://github.com/mortenebak)
- [Anders Grønborg](https://latego.dk)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
