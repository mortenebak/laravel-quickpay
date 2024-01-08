<?php

namespace Netbums\Quickpay\DataObjects;

readonly class Basket
{
    /**
     * @param  array<int, BasketItem>  $items
     */
    public function __construct(
        array $items = []
    ) {
    }

    public function toArray(): array
    {
        return [
            'basket' => $this->items,
        ];
    }
}
