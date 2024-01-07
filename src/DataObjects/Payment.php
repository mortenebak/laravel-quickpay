<?php

namespace Netbums\Quickpay\DataObjects;

readonly class Payment
{
    public function __construct(
        public string $currency,
        public string $order_id,
        public Basket $basket,
        public ?InvoiceAddress $invoice_address,
        public ?ShippingAddress $shipping_address,
    ) {
    }
}
