<?php

namespace Netbums\Quickpay\DataObjects;

readonly class Subscription
{
    public function __construct(
        public string $currency,
        public string $order_id,
        public string $description,
        public ?OptionalAddress $invoice_address = null,
        public ?OptionalAddress $shipping_address = null,
    ) {}

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'order_id' => $this->order_id,
            'description' => $this->description,
            'invoice_address' => $this->invoice_address?->toArray() ?? null,
            'shipping_address' => $this->shipping_address?->toArray() ?? null,
        ];
    }
}
