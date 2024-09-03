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
     * Fetch all payments
     *
     * @throws FetchPaymentsFailed
     */
    public function all(): array
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
     * Create Payment
     *
     * @throws CreatePaymentFailed
     */
    public function create(Payment $payment): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments';
        $this->data = $payment->toArray();
        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new CreatePaymentFailed(
                message: 'The payment could not be created. Error: '.$exception->getMessage(),
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
    public function createLink(PaymentLink $paymentLink): array
    {
        $id = $paymentLink->id;
        $this->method = 'put';
        $this->endpoint = 'payments/'.$id.'/link';
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
    public function deleteLink(int $id): array
    {
        $this->method = 'delete';
        $this->endpoint = 'payments/'.$id.'/link';

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
    public function find(int $id): array
    {
        $this->method = 'get';
        $this->endpoint = 'payments/'.$id;

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new FetchPaymentFailed(
                message: 'The payment with id '.$id.' could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * Create payment session
     *
     * @throws CreatePaymentSessionFailed
     */
    public function createPaymentSession(int $id, int $amount): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments/'.$id.'/session';

        $this->data = [
            'id' => $id,
            'amount' => $amount,
        ];

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new CreatePaymentSessionFailed(
                message: 'The payment session with id '.$id.' could not be created.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * authorize payment
     *
     * @throws AuthorizePaymentFailed
     */
    public function authorize(int $id, int $amount): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments/'.$id.'/authorize';

        $this->data = [
            'id' => $id,
            'amount' => $amount,
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new AuthorizePaymentFailed(
                message: 'The payment with id '.$id.' could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * capture payment
     *
     * @throws CapturePaymentFailed
     */
    public function capture(int $id, int $amount): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments/'.$id.'/capture';

        $this->data = [
            'id' => $id,
            'amount' => $amount,
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new CapturePaymentFailed(
                message: 'The payment with id '.$id.' could not be captured.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * refund payment
     *
     * @throws RefundPaymentFailed
     */
    public function refund(int $id, int $amount): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments/'.$id.'/refund';

        $this->data = [
            'id' => $id,
            'amount' => $amount,
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new RefundPaymentFailed(
                message: 'The payment with id '.$id.' could not be refunded.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;

    }

    /**
     * cancel payment
     *
     * @throws CancelPaymentFailed
     */
    public function cancel(int $id): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments/'.$id.'/cancel';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new CancelPaymentFailed(
                message: 'The payment with id '.$id.' could not be canceled.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * renew authorization
     *
     * @throws RenewPaymentFailed
     */
    public function renew(int $id): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments/'.$id.'/renew';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new RenewPaymentFailed(
                message: 'The payment with id '.$id.' could not be renewed.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    /**
     * create fraud confirmation report
     *
     * @throws CreateFraudConfirmationReportFailed
     */
    public function createFraudConfirmationReport(int $id, ?string $description = null): array
    {
        $this->method = 'post';
        $this->endpoint = 'payments/'.$id.'/fraud-report';

        $this->data = [
            'description' => $description,
        ];

        try {
            $response = $this->request($this->method, $this->endpoint, $this->data);
        } catch (Throwable $exception) {
            throw new CreateFraudConfirmationReportFailed(
                message: 'The fraud confirmation report for payment with id '.$id.' could not be created.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }
}
