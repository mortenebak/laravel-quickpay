<?php

declare(strict_types=1);

use Netbums\Quickpay\Exceptions\CardNotAccepted;
use Netbums\Quickpay\Exceptions\Payments\FetchPaymentFailed;
use Netbums\Quickpay\Exceptions\QuickPayValidationError;
use Netbums\Quickpay\Resources\PaymentResource;

function runInProduction(): void
{
    app()->detectEnvironment(fn () => 'production');
    config()->set('app.env', 'production');
}

it('returns the decoded response', function () {
    [$client] = $this->fakeClient(['id' => 42, 'test_mode' => false]);

    expect((new PaymentResource($client))->find(42))->toBe(['id' => 42, 'test_mode' => false]);
});

it('returns the response of a successful request in production', function () {
    runInProduction();

    [$client] = $this->fakeClient(['id' => 42, 'test_mode' => false]);

    expect((new PaymentResource($client))->find(42))->toBe(['id' => 42, 'test_mode' => false]);
});

it('refuses a test mode transaction in production', function () {
    runInProduction();

    [$client] = $this->fakeClient(['id' => 42, 'test_mode' => true]);

    try {
        (new PaymentResource($client))->find(42);
    } catch (FetchPaymentFailed $exception) {
        expect($exception->getPrevious())->toBeInstanceOf(CardNotAccepted::class);

        return;
    }

    $this->fail('A test mode transaction was accepted in production.');
});

it('accepts a test mode transaction outside production', function () {
    [$client] = $this->fakeClient(['id' => 42, 'test_mode' => true]);

    expect((new PaymentResource($client))->find(42))->toHaveKey('test_mode', true);
});

it('returns an empty array when the response has no body', function () {
    [$client, $fake] = $this->fakeClient(statusCode: 204);
    $fake->body      = '';

    expect((new PaymentResource($client))->deleteLink(42))->toBe([]);
});

it('wraps an error response with its status code', function () {
    [$client] = $this->fakeClient(['message' => 'Not found'], 404);

    try {
        (new PaymentResource($client))->find(42);
    } catch (FetchPaymentFailed $exception) {
        expect($exception->getCode())->toBe(404)
            ->and($exception->getMessage())->toContain('Not found')
            ->and($exception->getPrevious())->toBeInstanceOf(QuickPayValidationError::class);

        return;
    }

    $this->fail('An error response did not throw.');
});
