<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Netbums\Quickpay\Exceptions\ConfigNotCorrect;
use Netbums\Quickpay\Facades\Quickpay;
use Netbums\Quickpay\Quickpay as QuickpayClient;
use Netbums\Quickpay\Resources\PaymentResource;
use Netbums\Quickpay\Resources\SubscriptionResource;
use Netbums\Quickpay\Support\CallbackVerifier;

it('merges the package config without publishing it', function () {
    expect(config()->has('quickpay.merchant_id'))->toBeTrue();
});

it('resolves the same instance from the container', function () {
    expect(app(QuickpayClient::class))->toBe(app(QuickpayClient::class));
});

it('provides resource accessors via the facade', function () {
    expect(Quickpay::payments())->toBeInstanceOf(PaymentResource::class);
    expect(Quickpay::subscriptions())->toBeInstanceOf(SubscriptionResource::class);
    expect(Quickpay::callbacks())->toBeInstanceOf(CallbackVerifier::class);
});

it('accepts login and password instead of an api key', function () {
    config()->set('quickpay.api_key', null);
    config()->set('quickpay.login', 'user');
    config()->set('quickpay.password', 'secret');

    expect(new QuickpayClient())->toBeInstanceOf(QuickpayClient::class);
});

it('throws when no credentials are configured', function () {
    config()->set('quickpay.api_key', null);

    new QuickpayClient();
})->throws(ConfigNotCorrect::class);

it('throws when callbacks are verified without a private key', function () {
    config()->set('quickpay.private_key', null);

    Quickpay::callbacks();
})->throws(ConfigNotCorrect::class);

it('registers the install command', function () {
    expect(array_keys(Artisan::all()))->toContain('quickpay:install');
});
