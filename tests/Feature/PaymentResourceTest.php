<?php

declare(strict_types=1);

use Netbums\Quickpay\DataObjects\Basket;
use Netbums\Quickpay\DataObjects\BasketItem;
use Netbums\Quickpay\DataObjects\Payment;
use Netbums\Quickpay\DataObjects\PaymentLink;
use Netbums\Quickpay\Resources\PaymentResource;

it('calls the expected payment endpoint', function (Closure $call, string $method, string $path, array $data) {
    [$client, $fake] = $this->fakeClient(['id' => 42]);

    $call(new PaymentResource($client));

    expect($fake->lastCall())->toBe(['method' => $method, 'path' => $path, 'data' => $data]);
})->with([
    'all'          => [fn (PaymentResource $payments) => $payments->all(), 'get', 'payments', []],
    'find'         => [fn (PaymentResource $payments) => $payments->find(42), 'get', 'payments/42', []],
    'delete link'  => [fn (PaymentResource $payments) => $payments->deleteLink(42), 'delete', 'payments/42/link', []],
    'session'      => [fn (PaymentResource $payments) => $payments->createPaymentSession(42, 100), 'post', 'payments/42/session', ['id' => 42, 'amount' => 100]],
    'authorize'    => [fn (PaymentResource $payments) => $payments->authorize(42, 100), 'post', 'payments/42/authorize', ['id' => 42, 'amount' => 100]],
    'capture'      => [fn (PaymentResource $payments) => $payments->capture(42, 100), 'post', 'payments/42/capture', ['id' => 42, 'amount' => 100]],
    'refund'       => [fn (PaymentResource $payments) => $payments->refund(42, 100), 'post', 'payments/42/refund', ['id' => 42, 'amount' => 100]],
    'cancel'       => [fn (PaymentResource $payments) => $payments->cancel(42), 'post', 'payments/42/cancel', []],
    'renew'        => [fn (PaymentResource $payments) => $payments->renew(42), 'post', 'payments/42/renew', []],
    'fraud report' => [fn (PaymentResource $payments) => $payments->createFraudConfirmationReport(42, 'Fraud'), 'post', 'payments/42/fraud-report', ['description' => 'Fraud']],
]);

it('creates a payment from a basket', function () {
    [$client, $fake] = $this->fakeClient(['id' => 42]);

    $response = (new PaymentResource($client))->create(new Payment(
        currency: 'DKK',
        order_id: '1234',
        basket: new Basket(items: [
            new BasketItem(qty: 1, item_no: 'sku-1234', item_name: 'Test item', item_price: 100, vat_rate: 0.25),
        ]),
    ));

    expect($response)->toBe(['id' => 42])
        ->and($fake->lastCall()['method'])->toBe('post')
        ->and($fake->lastCall()['path'])->toBe('payments')
        ->and($fake->lastCall()['data'])->toMatchArray([
            'currency' => 'DKK',
            'order_id' => '1234',
            'basket'   => [
                ['qty' => 1, 'item_no' => 'sku-1234', 'item_name' => 'Test item', 'item_price' => 100, 'vat_rate' => 0.25],
            ],
        ]);
});

it('creates a payment link', function () {
    [$client, $fake] = $this->fakeClient(['url' => 'https://payment.quickpay.net/payments/abc']);

    $response = (new PaymentResource($client))->createLink(new PaymentLink(id: 42, amount: 100, language: 'da'));

    expect($response)->toBe(['url' => 'https://payment.quickpay.net/payments/abc'])
        ->and($fake->lastCall()['method'])->toBe('put')
        ->and($fake->lastCall()['path'])->toBe('payments/42/link')
        ->and($fake->lastCall()['data'])->toMatchArray(['amount' => 100, 'language' => 'da']);
});
