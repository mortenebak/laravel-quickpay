<?php

declare(strict_types=1);

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
     * Make a request to the Quickpay API
     *
     * @throws CardNotAccepted
     * @throws QuickPayValidationError
     */
    public function request(string $method, string $endpoint, array $data = []): array
    {
        $response = $this->client->request->$method($endpoint, $data);

        if ($response->status_code >= 200 && $response->status_code < 300) {
            $result = json_decode($response->response_data, true) ?? [];

            // A transaction made with a test card must never be treated as a real one in production.
            if (app()->isProduction() && ($result['test_mode'] ?? false) === true) {
                throw new CardNotAccepted(
                    message: 'You cannot use test cards in production mode.',
                    code: 402
                );
            }

            return $result;

        } else {
            $message = json_decode($response->response_data, true);

            throw new QuickPayValidationError(
                message: 'The request was not valid: '.json_encode($message), // must be encoded since array.
                code: $response->status_code
            );
        }
    }
}
