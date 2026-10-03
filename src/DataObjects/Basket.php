<?php

declare(strict_types=1);

namespace Netbums\Quickpay\DataObjects;

readonly class Basket
{
    /**
     * @param  array<BasketItem|array<string, mixed>>  $items
     */
    public function __construct(
        public array $items = []
    ) {}

    public function toArray(): array
    {
        return array_map(
            fn (BasketItem|array $item) => $item instanceof BasketItem ? $item->toArray() : $item,
            $this->items,
        );
    }
}
