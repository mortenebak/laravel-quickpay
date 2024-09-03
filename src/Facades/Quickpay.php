<?php

namespace Netbums\Quickpay\Facades;

use Illuminate\Support\Facades\Facade;
use Netbums\Quickpay\Resources\PaymentResource;
use Netbums\Quickpay\Resources\SubscriptionResource;

/**
 * @method static PaymentResource payments();
 * @method static SubscriptionResource subscriptions();
 */
class Quickpay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Netbums\Quickpay\Quickpay::class;
    }
}
