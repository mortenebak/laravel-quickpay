<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Netbums\Quickpay\Support\CallbackVerifier;

beforeEach(function () {
    $this->body     = '{"id":42,"accepted":true}';
    $this->checksum = hash_hmac('sha256', $this->body, 'test-private-key');
});

it('calculates the checksum of a callback body', function () {
    expect((new CallbackVerifier('test-private-key'))->checksum($this->body))->toBe($this->checksum);
});

it('accepts a callback signed with the private key', function () {
    expect((new CallbackVerifier('test-private-key'))->isValid($this->body, $this->checksum))->toBeTrue();
});

it('rejects a callback with a wrong, tampered or missing checksum', function () {
    $verifier = new CallbackVerifier('test-private-key');

    expect($verifier->isValid($this->body, 'wrong'))->toBeFalse()
        ->and($verifier->isValid('{"id":42,"accepted":false}', $this->checksum))->toBeFalse()
        ->and($verifier->isValid($this->body, null))->toBeFalse();
});

it('verifies an incoming request by its checksum header', function () {
    $verifier = new CallbackVerifier('test-private-key');

    $request = Request::create('/callback', 'POST', content: $this->body);
    expect($verifier->isValidRequest($request))->toBeFalse();

    $request->headers->set('Quickpay-Checksum-Sha256', $this->checksum);
    expect($verifier->isValidRequest($request))->toBeTrue();
});
