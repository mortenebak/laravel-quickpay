<?php

declare(strict_types=1);

use Netbums\Quickpay\DataObjects\BasketItem;
use Netbums\Quickpay\DataObjects\OptionalAddress;
use Netbums\Quickpay\DataObjects\PaymentLink;
use Netbums\Quickpay\DataObjects\SubscriptionLink;
use Netbums\Quickpay\DataObjects\SubscriptionRecurring;

it('builds a basket item from an array', function () {
    $data = ['qty' => 2, 'item_no' => 'sku-1', 'item_name' => 'Item', 'item_price' => 500, 'vat_rate' => 0.25];

    expect(BasketItem::fromArray($data)->toArray())->toBe($data);
});

it('builds an address from a partial array', function () {
    $address = OptionalAddress::fromArray(['name' => 'Jane Doe', 'city' => 'Aarhus']);

    expect($address->name)->toBe('Jane Doe')
        ->and($address->city)->toBe('Aarhus')
        ->and($address->street)->toBeNull();
});

it('builds a payment link without the optional fields', function () {
    $link = PaymentLink::fromArray(['id' => 42, 'amount' => 100]);

    expect($link->id)->toBe(42)
        ->and($link->amount)->toBe(100)
        ->and($link->auto_capture)->toBeNull();
});

it('builds a subscription link without the optional fields', function () {
    $link = SubscriptionLink::fromArray(['id' => 42, 'amount' => 100]);

    expect($link->id)->toBe(42)->and($link->language)->toBeNull();
});

it('builds a recurring payment without auto capture', function () {
    $recurring = SubscriptionRecurring::fromArray(['id' => 42, 'order_id' => '1235', 'amount' => 100]);

    expect($recurring->auto_capture)->toBeNull();
});
