<?php

namespace Netbums\Quickpay;

use QuickPay\QuickPay as QuickPayVendor;

class Quickpay
{
    protected $client;

    public function __construct()
    {
        $credentials = null;

        if (config('quickpay.api_key')) {
            $credentials = ":".config('quickpay.api_key');
        } else if (config('quickpay.login') && config('quickpay.password')) {
            $credentials = sprintf('%s:%s', config('quickpay.login'), config('quickpay.password'));
        }

        if (!$credentials) {
            throw new ConfigNotCorrect('You should specify an `api_key` or `login` and `password` in the `quickpay` config file');
        }

        $this->client = new QuickPayVendor($credentials);

    }

    public function payments(): PaymentResource
    {
        return new PaymentResource($this->client);
    }

}
