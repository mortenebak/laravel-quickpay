<?php

namespace Netbums\Quickpay\Resources;

use Netbums\Quickpay\Exceptions\Subscriptions\FetchSubscriptionsFailed;
use Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer;
use Throwable;

class SubscriptionResource
{
    use QuickpayApiConsumer;

    /**
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

    /**
     * @param string $subscriptionId
     * @return array
     * @throws FetchSubscriptionFailed
     */
    public function find(string $subscriptionId): array
    {
        $this->method = 'get';
        $this->endpoint = "subscriptions/{$subscriptionId}";

        try {
            return $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new FetchSubscriptionFailed(
                message: 'The subscription could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }
    }

    public function createPaymentLink(string $subscriptionId): array
    {
        $this->method = 'put';
        $this->endpoint = "subscriptions/{$subscriptionId}/link";

        return [];
    }

    public function deletePaymentLink(string $subscriptionId): array
    {
        $this->method = 'delete';
        $this->endpoint = "subscriptions/{$subscriptionId}/link";

        return [];
    }

    // @see https://learn.quickpay.net/tech-talk/api/services/#POST-subscriptions---format-
    // TODO: convert the provided array to a DTO
    public function create(array $data): array
    {
        $this->method = 'post';
        $this->endpoint = 'subscriptions';

        try {
            return $this->request($this->method, $this->endpoint, $data);
        } catch (Throwable $exception) {
            throw new QuickPayValidationError(
                message: 'The subscription could not be created.',
                code: $exception->getCode(),
                previous: $exception
            );
        }
    }

    // TODO: convert the provided array to a DTO
    public function update(string $subscriptionId, array $data): array
    {
        $this->method = 'patch';
        $this->endpoint = "subscriptions/{$subscriptionId}";

        return [];
    }

    public function authorize(string $subscriptionId): array
    {
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$subscriptionId}/authorize";

        return [];
    }

    public function cancel(string $subscriptionId): array
    {
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$subscriptionId}/cancel";

        return [];
    }

    public function recurring(string $subscriptionId): array
    {
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$subscriptionId}/recurring";

        return [];
    }

    public function fraudReport(string $subscriptionId): array
    {
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$subscriptionId}/fraud-report";

        return [];
    }

    public function getPayments(string $subscriptionId): array
    {
        $this->method = 'get';
        $this->endpoint = "subscriptions/{$subscriptionId}/payments";

        return [];
    }
}
