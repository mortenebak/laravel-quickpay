<?php

declare(strict_types=1);

namespace Netbums\Quickpay\Support;

use Illuminate\Http\Request;
use SensitiveParameter;

/**
 * Verifies that a callback was sent by Quickpay: the request body is signed with the
 * account's private key and the signature is sent in the `Quickpay-Checksum-Sha256` header.
 */
class CallbackVerifier
{
    public const CHECKSUM_HEADER = 'Quickpay-Checksum-Sha256';

    public function __construct(
        #[SensitiveParameter]
        protected string $privateKey,
    ) {}

    public function checksum(string $body): string
    {
        return hash_hmac('sha256', $body, $this->privateKey);
    }

    public function isValid(string $body, ?string $checksum): bool
    {
        if ($checksum === null || $checksum === '') {
            return false;
        }

        return hash_equals($this->checksum($body), $checksum);
    }

    public function isValidRequest(Request $request): bool
    {
        return $this->isValid($request->getContent(), $request->header(self::CHECKSUM_HEADER));
    }
}
