<?php

namespace Netbums\Quickpay\Resources;

use Netbums\Quickpay\DataObjects\Payment;
use Netbums\Quickpay\DataObjects\PaymentLink;
use Netbums\Quickpay\Exceptions\Payments\AuthorizePaymentFailed;
use Netbums\Quickpay\Exceptions\Payments\CancelPaymentFailed;
use Netbums\Quickpay\Exceptions\Payments\CapturePaymentFailed;
use Netbums\Quickpay\Exceptions\Payments\CreateFraudConfirmationReportFailed;
use Netbums\Quickpay\Exceptions\Payments\CreatePaymentFailed;
use Netbums\Quickpay\Exceptions\Payments\CreatePaymentLinkFailed;
use Netbums\Quickpay\Exceptions\Payments\CreatePaymentSessionFailed;
use Netbums\Quickpay\Exceptions\Payments\DeletePaymentLinkFailed;
use Netbums\Quickpay\Exceptions\Payments\FetchPaymentFailed;
use Netbums\Quickpay\Exceptions\Payments\FetchPaymentsFailed;
use Netbums\Quickpay\Exceptions\Payments\RefundPaymentFailed;
use Netbums\Quickpay\Exceptions\Payments\RenewPaymentFailed;
use Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer;
use Throwable;

class PaymentResource
{
    use QuickpayApiConsumer;

    /**
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
     *
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
     *
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
     *
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

    /**
     * Create payment session
     * @param int $id
     * @return object
     * @throws CreatePaymentSessionFailed
     */
    public function createPaymentSession(int $id): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/session';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new CreatePaymentSessionFailed(
                message: 'The payment session with id ' . $id . ' could not be created.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * authorize payment
     * @param int $id
     * @param int $amount
     * @return object
     * @throws AuthorizePaymentFailed
     */
    public function authorize(int $id, int $amount): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/authorize';

        $this->data = [
            'id' => $id,
            'amount' => $amount
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new AuthorizePaymentFailed(
                message: 'The payment with id ' . $id . ' could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * capture payment
     * @param int $id
     * @param int $amount
     * @return object
     * @throws CapturePaymentFailed
     */
    public function capture(int $id, int $amount): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/capture';

        $this->data = [
            'id' => $id,
            'amount' => $amount
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new CapturePaymentFailed(
                message: 'The payment with id ' . $id . ' could not be captured.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * refund payment
     * @param int $id
     * @param int $amount
     * @return object
     * @throws RefundPaymentFailed
     */
    public function refund(int $id, int $amount): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/refund';

        $this->data = [
            'id' => $id,
            'amount' => $amount
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new RefundPaymentFailed(
                message: 'The payment with id ' . $id . ' could not be refunded.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;

    }

    /**
     * cancel payment
     * @param int $id
     * @return object
     * @throws CancelPaymentFailed
     */
    public function cancel(int $id): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/cancel';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new CancelPaymentFailed(
                message: 'The payment with id ' . $id . ' could not be canceled.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * renew authorization
     * @param int $id
     * @return object
     * @throws RenewPaymentFailed
     */
    public function renew(int $id): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/renew';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new RenewPaymentFailed(
                message: 'The payment with id ' . $id . ' could not be renewed.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * create fraud confirmation report
     * @param int $id
     * @param string|null $description
     * @return object
     * @throws CreateFraudConfirmationReportFailed
     */
    public function createFraudConfirmationReport(int $id, ?string $description = null): object
    {
        $this->method = 'post';
        $this->endpoint = 'payments/' . $id . '/fraud-report';

        $this->data = [
            'description' => $description
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new CreateFraudConfirmationReportFailed(
                message: 'The fraud confirmation report for payment with id ' . $id . ' could not be created.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }
}
