<?php

declare(strict_types=1);

namespace Netbums\Quickpay\Tests;

use Netbums\Quickpay\QuickpayServiceProvider;
use Netbums\Quickpay\Tests\Fakes\FakeRequest;
use Orchestra\Testbench\TestCase as Orchestra;
use QuickPay\QuickPay as QuickPayClient;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [QuickpayServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('quickpay.api_key', 'test-api-key');
        $app['config']->set('quickpay.private_key', 'test-private-key');
    }

    /**
     * A Quickpay client whose requests are answered by the returned fake.
     *
     * @param  array<mixed>  $response
     * @return array{0: QuickPayClient, 1: FakeRequest}
     */
    protected function fakeClient(array $response = [], int $statusCode = 200): array
    {
        $client = new QuickPayClient(':test-api-key');

        $fake             = new FakeRequest($client->request->client);
        $fake->statusCode = $statusCode;
        $fake->body       = (string) json_encode($response);

        $client->request = $fake;

        return [$client, $fake];
    }
}
