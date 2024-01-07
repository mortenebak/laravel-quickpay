<?php

namespace Netbums\Quickpay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Netbums\Quickpay\Quickpay
 */
class Quickpay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Netbums\Quickpay\Quickpay::class;
    }
}
