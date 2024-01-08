<?php

namespace Netbums\Quickpay\Resources;

use Netbums\Quickpay\DataObjects\Payment;
use Netbums\Quickpay\DataObjects\PaymentLink;
use Netbums\Quickpay\Exceptions\CreatePaymentFailed;
use Netbums\Quickpay\Exceptions\CreatePaymentLinkFailed;
use Netbums\Quickpay\Exceptions\DeletePaymentLinkFailed;
use Netbums\Quickpay\Exceptions\FetchPaymentFailed;
use Netbums\Quickpay\Exceptions\FetchPaymentsFailed;
use Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer;
use Throwable;

class PaymentResource
{
    use QuickpayApiConsumer;

    /**
     * @return object
     * @throws FetchPaymentsFailed
     */
    public function all(): object
    {
        $this->method = 'get';
        $this->endpoint = 'payments';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new FetchPaymentsFailed(
                message: 'The payments could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * @param Payment $payment
     * @return object
     * @throws CreatePaymentFailed
     */
    public function create(Payment $payment): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments';
        $this->data = $payment->toArray();

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new CreatePaymentFailed(
                message: 'The payment could not be created.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * Create or Update the Payment Link
     * @param int $id
     * @param PaymentLink $paymentLink
     * @return object
     * @throws CreatePaymentLinkFailed
     */
    public function createLink(int $id, PaymentLink $paymentLink): object
    {
        $this->method = 'put';
        $this->endpoint = 'payments/' . $id . '/link';
        $this->data = $paymentLink->toArray();

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new CreatePaymentLinkFailed(
                message: 'The payment link could not be created.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * Delete payment link
     * @param int $id
     * @return object
     * @throws DeletePaymentLinkFailed
     */
    public function deleteLink(int $id): object
    {
        $this->method = 'delete';
        $this->endpoint = 'payments/' . $id . '/link';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new DeletePaymentLinkFailed(
                message: 'The payment link could not be deleted.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * Get Payment
     * @param int $id
     * @return object
     * @throws FetchPaymentFailed
     */
    public function find(int $id): object
    {
        $this->method = 'get';
        $this->endpoint = 'payments/' . $id;

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new FetchPaymentFailed(
                message: 'The payment with id ' . $id . ' could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    // Create payment session
    public function createPaymentSession($id)
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/session';
    }

    // authorize payment
    public function authorize($id)
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/authorize';
    }

    // capture payment
    public function capture($id)
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/capture';
    }

    // refund payment
    public function refund($id)
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/refund';
    }

    // cancel payment
    public function cancel($id)
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/cancel';
    }

    // renew authorization
    public function renew($id)
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/renew';
    }

    // create fraud confirmation report
    public function createFraudConfirmationReport($id)
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/fraud-report';
    }
}
