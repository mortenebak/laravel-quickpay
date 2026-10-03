<?php

declare(strict_types=1);

namespace Netbums\Quickpay\Facades;

use Illuminate\Support\Facades\Facade;
use Netbums\Quickpay\Resources\PaymentResource;
use Netbums\Quickpay\Resources\SubscriptionResource;
use Netbums\Quickpay\Support\CallbackVerifier;

/**
 * @method static PaymentResource payments()
 * @method static SubscriptionResource subscriptions()
 * @method static CallbackVerifier callbacks()
 */
class Quickpay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Netbums\Quickpay\Quickpay::class;
    }
}
