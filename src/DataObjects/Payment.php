<?php

namespace Netbums\Quickpay\DataObjects;

readonly class Payment
{
    public function __construct(
        public string $currency,
        public string $order_id,
        public Basket $basket,
        public ?OptionalAddress $invoice_address,
        public ?OptionalAddress $shipping_address,
    ) {
    }

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'order_id' => $this->order_id,
            'basket' => $this->basket->toArray(),
            'invoice_address' => $this->invoice_address?->toArray(),
            'shipping_address' => $this->shipping_address?->toArray(),
        ];
    }
}
