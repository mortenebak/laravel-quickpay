<?php

namespace Netbums\Quickpay\Resources\Concerns;

use Netbums\Quickpay\Exceptions\CardNotAccepted;
use Netbums\Quickpay\Exceptions\QuickPayTestNotAllowed;
use Netbums\Quickpay\Exceptions\QuickPayValidationError;
use QuickPay\QuickPay as QuickPayVendor;

trait QuickpayApiConsumer
{

    public QuickPayVendor $client;

    public string $endpoint;

    public string $method;

    public array $data;

    public function __construct(QuickPayVendor $client)
    {
    }

    public function request(string $method, string $endpoint, array $data = []): object
    {
        $response = $this->client->request->$method($endpoint, $data);

        if ($response->isSuccess()) {
            $data = $response->asObject();

            if (app()->environment('production') && $data->test_mode) {
                throw new QuickPayTestNotAllowed(
                    message: 'You are not allowed to use test cards in production mode',
                    code: 403
                );
            }

            if (!empty($data->operations) && !$data->accepted) {
                throw new CardNotAccepted(
                    message: 'The card was not accepted',
                    code: 402
                );
            }

            return $data;
        } else {
            throw new QuickPayValidationError(
                message: 'The request was not valid',
                code: 400
            );
        }
    }

}
