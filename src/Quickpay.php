<?php

namespace Netbums\Quickpay;

use Netbums\Quickpay\Exceptions\ConfigNotCorrect;
use Netbums\Quickpay\Resources\CardResource;
use Netbums\Quickpay\Resources\FeeResource;
use Netbums\Quickpay\Resources\PaymentResource;
use Netbums\Quickpay\Resources\PayoutResource;
use Netbums\Quickpay\Resources\SubscriptionResource;

class Quickpay
{
    protected \QuickPay\QuickPay $client;

    public function __construct()
    {
        $credentials = null;

        if (config('quickpay.api_key')) {
            $credentials = ':'.config('quickpay.api_key');
        } elseif (config('quickpay.login') && config('quickpay.password')) {
            $credentials = sprintf('%s:%s', config('quickpay.login'), config('quickpay.password'));
        }

        if (! $credentials) {
            throw new ConfigNotCorrect('You should specify an `api_key` or `login` and `password` in the `quickpay` config file');
        }

        $this->client = new \QuickPay\QuickPay($credentials);

    }

    public static function api(): static
    {
        return new static;
    }

    public function payments(): PaymentResource
    {
        return new PaymentResource(
            client: $this->client
        );
    }

    public function subscriptions(): SubscriptionResource
    {
        return new SubscriptionResource(
            client: $this->client
        );
    }

    public function cards(): CardResource
    {
        return new CardResource(
            client: $this->client
        );
    }

    public function payouts(): PayoutResource
    {
        return new PayoutResource(
            client: $this->client
        );
    }

    public function fees(): FeeResource
    {
        return new FeeResource(
            client: $this->client
        );
    }
}
