<?php

namespace Netbums\Quickpay\Facades;

use Illuminate\Support\Facades\Facade;
use Netbums\Quickpay\Resources\CardResource;
use Netbums\Quickpay\Resources\FeeResource;
use Netbums\Quickpay\Resources\PaymentResource;
use Netbums\Quickpay\Resources\PayoutResource;
use Netbums\Quickpay\Resources\SubscriptionResource;

/**
 * @method static PaymentResource payments();
 * @method static SubscriptionResource subscriptions();
 * @method static CardResource cards();
 * @method static FeeResource fees();
 * @method static PayoutResource payouts();
 */
class Quickpay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Netbums\Quickpay\Quickpay::class;
    }
}
