<?php

namespace Netbums\Quickpay\DataObjects;

readonly class Basket
{
    public function __construct(
        public array $items = []
    ) {}

    public function toArray(): array
    {
        return $this->items;
    }
}
