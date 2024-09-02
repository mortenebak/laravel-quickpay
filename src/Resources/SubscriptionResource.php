<?php

namespace Netbums\Quickpay\Resources;

use Netbums\Quickpay\Exceptions\CardNotAccepted;
use Netbums\Quickpay\Exceptions\QuickPayValidationError;
use Netbums\Quickpay\Exceptions\Subscriptions\FetchSubscriptionsFailed;
use Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer;
use Throwable;

class SubscriptionResource
{
    use QuickpayApiConsumer;

    /**
     * @throws CardNotAccepted
     * @throws QuickPayValidationError
     * @throws FetchSubscriptionsFailed
     */
    public function all(): array
    {
        $this->method = 'get';
        $this->endpoint = 'subscriptions';

        try {
            return $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new FetchSubscriptionsFailed(
                message: 'The subscriptions could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }
    }
}
