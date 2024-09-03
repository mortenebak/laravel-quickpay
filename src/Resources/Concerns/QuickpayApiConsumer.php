<?php

namespace Netbums\Quickpay\Resources\Concerns;

use Netbums\Quickpay\Exceptions\CardNotAccepted;
use Netbums\Quickpay\Exceptions\QuickPayValidationError;
use QuickPay\QuickPay;

trait QuickpayApiConsumer
{
    public string $endpoint;

    public string $method;

    public array $data = [];

    public function __construct(public QuickPay $client) {}

    /**
     * @throws CardNotAccepted
     * @throws QuickPayValidationError
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        $response = $this->client->request->$method($endpoint, $data);

        if ($response->status_code >= 200 && $response->status_code < 300) {

            // if app is in production mode, and the request is not a test, and the card is not accepted, throw an exception
            if (config('app.env') === 'production') { // Todo: check if in test mode or if not accepted
                throw new CardNotAccepted(
                    message: 'You cannot use test cards in production mode.',
                    code: 402
                );
            }

            return json_decode($response->response_data, true);

        } else {
            $message = json_decode($response->response_data, true);

            throw new QuickPayValidationError(
                message: 'The request was not valid: '.$message,
                code: $response->status_code
            );
        }
    }
}
