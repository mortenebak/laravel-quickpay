<?php

declare(strict_types=1);

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('all data objects are readonly')
    ->expect('Netbums\Quickpay\DataObjects')
    ->toBeReadonly();

arch('all exceptions extend the base exception')
    ->expect('Netbums\Quickpay\Exceptions')
    ->toExtend('Netbums\Quickpay\Exceptions\QuickpayException');

arch('resource classes use the api consumer trait')
    ->expect('Netbums\Quickpay\Resources')
    ->classes()
    ->toUseTrait('Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer');
