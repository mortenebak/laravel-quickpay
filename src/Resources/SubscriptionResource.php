<?php

namespace Netbums\Quickpay\Resources;

use Netbums\Quickpay\DataObjects\Subscription;
use Netbums\Quickpay\DataObjects\SubscriptionLink;
use Netbums\Quickpay\DataObjects\SubscriptionRecurring;
use Netbums\Quickpay\Exceptions\QuickPayValidationError;
use Netbums\Quickpay\Exceptions\Subscriptions\FetchSubscriptionFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\FetchSubscriptionsFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\CreateRecurringFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\CreateSubscriptionFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\CreateSubscriptionLinkFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\DeletePaymentLinkFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\UpdateSubscriptionFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\AuthorizeSubscriptionFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\CancelSubscriptionFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\FraudReportSubscriptionFailed;
use Netbums\Quickpay\Exceptions\Subscriptions\GetSubscriptionPaymentsFailed;
use Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer;

use Throwable;

use Illuminate\Support\Facades\Log;

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
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {

            throw new FetchSubscriptionsFailed(
                message: 'The subscriptions could not be fetched: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * @throws FetchSubscriptionFailed
     */
    public function find(string $subscriptionId): array
    {
        $this->method = 'get';
        $this->endpoint = "subscriptions/{$subscriptionId}";

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {

            throw new FetchSubscriptionFailed(
                message: 'The subscription could not be fetched: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    public function createSubscriptionLink(SubscriptionLink $subscriptionLink): array
    {
        $id = $subscriptionLink->id;
        $this->method = 'put';
        $this->endpoint = "subscriptions/{$id}/link";
        $this->data = $subscriptionLink->toArray();

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {

            throw new CreateSubscriptionLinkFailed(
                message: 'The subscription payment link could not be created: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * @throws DeletePaymentLinkFailed
     */
    public function deletePaymentLink(string $subscriptionId): array
    {
        $this->method = 'delete';
        $this->endpoint = "subscriptions/{$subscriptionId}/link";

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new DeletePaymentLinkFailed(
                message: 'The subscription payment link could not be deleted: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    // @see https://learn.quickpay.net/tech-talk/api/services/#POST-subscriptions---format-
    // TODO: convert the provided array to a DTO
    /**
     * @throws QuickPayValidationError
     */
    public function create(Subscription $subscription): array
    {
        $this->method = 'post';
        $this->endpoint = 'subscriptions';
        $this->data = $subscription->toArray();

       // dd($this->data);
        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {

            throw new CreateSubscriptionFailed(
                message: 'The subscription could not be created: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    // TODO: convert the provided array to a DTO
    // TODO: convert the provided array to a DTO
    /**
     * @throws UpdateSubscriptionFailed
     */
    public function update(string $subscriptionId, array $data): array
    {
        $this->method = 'patch';
        $this->endpoint = "subscriptions/{$subscriptionId}";
        $this->data = $data;

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new UpdateSubscriptionFailed(
                message: 'The subscription could not be updated: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * @throws AuthorizeSubscriptionFailed
     */
    public function authorize(string $subscriptionId): array
    {
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$subscriptionId}/authorize";

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new AuthorizeSubscriptionFailed(
                message: 'The subscription could not be authorized: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * @throws CancelSubscriptionFailed
     */
    public function cancel(string $subscriptionId): array
    {
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$subscriptionId}/cancel";

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new CancelSubscriptionFailed(
                message: 'The subscription could not be canceled: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    public function createRecurring(SubscriptionRecurring $subscriptionRecurring): array
    {
        $id = $subscriptionRecurring->id;
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$id}/recurring";
        $this->data = $subscriptionRecurring->toArray();

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {

            throw new CreateRecurringFailed(
                message: 'The subscription recurring payment could not be created: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );

        }

        return $response;
    }

    /**
     * @throws FraudReportSubscriptionFailed
     */
    public function fraudReport(string $subscriptionId): array
    {
        $this->method = 'post';
        $this->endpoint = "subscriptions/{$subscriptionId}/fraud-report";

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new FraudReportSubscriptionFailed(
                message: 'The subscription fraud report could not be created: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * @throws GetSubscriptionPaymentsFailed
     */
    public function getPayments(string $subscriptionId): array
    {
        $this->method = 'get';
        $this->endpoint = "subscriptions/{$subscriptionId}/payments";

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new GetSubscriptionPaymentsFailed(
                message: 'The subscription payments could not be fetched: '.$exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }
}
