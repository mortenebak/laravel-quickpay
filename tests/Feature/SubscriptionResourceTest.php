<?php

declare(strict_types=1);

use Netbums\Quickpay\DataObjects\Subscription;
use Netbums\Quickpay\DataObjects\SubscriptionLink;
use Netbums\Quickpay\DataObjects\SubscriptionRecurring;
use Netbums\Quickpay\Exceptions\Subscriptions\CreateSubscriptionFailed;
use Netbums\Quickpay\Resources\SubscriptionResource;

it('calls the expected subscription endpoint', function (Closure $call, string $method, string $path, array $data) {
    [$client, $fake] = $this->fakeClient(['id' => 42]);

    $call(new SubscriptionResource($client));

    expect($fake->lastCall())->toBe(['method' => $method, 'path' => $path, 'data' => $data]);
})->with([
    'all'          => [fn (SubscriptionResource $subscriptions) => $subscriptions->all(), 'get', 'subscriptions', []],
    'find'         => [fn (SubscriptionResource $subscriptions) => $subscriptions->find('42'), 'get', 'subscriptions/42', []],
    'delete link'  => [fn (SubscriptionResource $subscriptions) => $subscriptions->deletePaymentLink('42'), 'delete', 'subscriptions/42/link', []],
    'update'       => [fn (SubscriptionResource $subscriptions) => $subscriptions->update('42', ['description' => 'New']), 'patch', 'subscriptions/42', ['description' => 'New']],
    'authorize'    => [fn (SubscriptionResource $subscriptions) => $subscriptions->authorize('42'), 'post', 'subscriptions/42/authorize', []],
    'cancel'       => [fn (SubscriptionResource $subscriptions) => $subscriptions->cancel('42'), 'post', 'subscriptions/42/cancel', []],
    'fraud report' => [fn (SubscriptionResource $subscriptions) => $subscriptions->fraudReport('42'), 'post', 'subscriptions/42/fraud-report', []],
    'payments'     => [fn (SubscriptionResource $subscriptions) => $subscriptions->getPayments('42'), 'get', 'subscriptions/42/payments', []],
]);

it('creates a subscription', function () {
    [$client, $fake] = $this->fakeClient(['id' => 42]);

    $response = (new SubscriptionResource($client))->create(
        new Subscription(currency: 'DKK', order_id: '1234', description: 'Monthly'),
    );

    expect($response)->toBe(['id' => 42])
        ->and($fake->lastCall()['method'])->toBe('post')
        ->and($fake->lastCall()['path'])->toBe('subscriptions')
        ->and($fake->lastCall()['data'])->toMatchArray(['currency' => 'DKK', 'order_id' => '1234', 'description' => 'Monthly']);
});

it('creates a subscription link', function () {
    [$client, $fake] = $this->fakeClient(['url' => 'https://payment.quickpay.net/subscriptions/abc']);

    (new SubscriptionResource($client))->createSubscriptionLink(new SubscriptionLink(id: 42, amount: 100));

    expect($fake->lastCall()['method'])->toBe('put')
        ->and($fake->lastCall()['path'])->toBe('subscriptions/42/link')
        ->and($fake->lastCall()['data'])->toMatchArray(['amount' => 100]);
});

it('creates a recurring payment', function () {
    [$client, $fake] = $this->fakeClient(['id' => 43]);

    (new SubscriptionResource($client))->createRecurring(
        new SubscriptionRecurring(id: 42, order_id: '1235', amount: 100, auto_capture: true),
    );

    expect($fake->lastCall()['method'])->toBe('post')
        ->and($fake->lastCall()['path'])->toBe('subscriptions/42/recurring')
        ->and($fake->lastCall()['data'])->toMatchArray(['order_id' => '1235', 'amount' => 100, 'auto_capture' => true]);
});

it('throws a dedicated exception when the request fails', function () {
    [$client] = $this->fakeClient(['message' => 'Validation error'], 400);

    (new SubscriptionResource($client))->create(
        new Subscription(currency: 'DKK', order_id: '1234', description: 'Monthly'),
    );
})->throws(CreateSubscriptionFailed::class);
