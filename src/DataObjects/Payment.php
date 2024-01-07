<?php

namespace Netbums\Quickpay\DataObjects;

readonly class Payment
{
    public function __construct(
        public string           $currency,
        public string           $order_id,
        public Basket           $basket,
        public ?OptionalAddress $invoice_address,
        public ?OptionalAddress $shipping_address,
    )
    {
    }
}
