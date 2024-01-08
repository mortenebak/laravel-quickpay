<?php

namespace Netbums\Quickpay\Resources\Concerns;

use Netbums\Quickpay\Exceptions\CardNotAccepted;
use Netbums\Quickpay\Exceptions\QuickPayValidationError;
use QuickPay\QuickPay;

trait QuickpayApiConsumer
{
    public QuickPay $client;

    public string $endpoint;

    public string $method;

    public array $data;

    public function __construct(QuickPay $client)
    {
    }

    /**
     * @throws CardNotAccepted
     * @throws QuickPayValidationError
     */
    public function request(string $method, string $endpoint, array $data = []): object
    {
        $response = $this->client->request->$method($endpoint, $data);

        if ($response->isSuccess()) {
            $data = $response->asObject();

            // if app is in production mode, and the request is not a test, and the card is not accepted, throw an exception
            if (config('app.env') === 'production' && ! $data->test_mode && ! $data->accepted) {
                throw new CardNotAccepted(
                    message: 'You cannot use test cards in production mode.',
                    code: 402
                );
            }

            return $data->getStatus();
        } else {
            throw new QuickPayValidationError(
                message: 'The request was not valid',
                code: 400
            );
        }
    }
}
