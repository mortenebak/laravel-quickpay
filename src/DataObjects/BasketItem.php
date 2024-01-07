<?php

namespace Netbums\Quickpay\DataObjects;

readonly class BasketItem
{
    public function __construct(
        public int $qty,
        public string $item_no,
        public string $item_name,
        public int $item_price,
        public float $vat_rate
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            qty: $data['qty'],
            item_no: $data['item_no'],
            item_name: $data['item_name'],
            item_price: $data['item_price'],
            vat_rate: $data['vat_rate'],
        );
    }

    public function toArray(): array
    {
        return [
            'qty' => $this->qty,
            'item_no' => $this->item_no,
            'item_name' => $this->item_name,
            'item_price' => $this->item_price,
            'vat_rate' => $this->vat_rate,
        ];
    }
}
