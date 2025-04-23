<?php

namespace Netbums\Quickpay\DataObjects;

use phpDocumentor\Reflection\Types\Boolean;

readonly class SubscriptionRecurring
{
    public function __construct(
        public int $id, // transaction id
        public string $order_id,
        public int $amount, // Amount to authorize
        public ?bool   $auto_capture = null,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id: $data['id'],
            order_id: $data['order_id'],
            amount: $data['amount'],
            auto_capture: $data['auto_capture'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'auto_capture' => $this->auto_capture,
        ];
    }
}
