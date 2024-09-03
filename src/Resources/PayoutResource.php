<?php

namespace Netbums\Quickpay\Resources;

use Netbums\Quickpay\Exceptions\Payouts\FetchPayoutsFailed;
use Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer;
use Throwable;

class PayoutResource
{
    use QuickpayApiConsumer;

    /**
     * get payouts
     * @throws FetchPayoutsFailed
     */
    public function all(): array {
        $this->method = 'get';
        $this->endpoint = 'payments';

        try {
            $response = $this->request($this->method, $this->endpoint);
        } catch (Throwable $exception) {
            throw new FetchPayoutsFailed(
                message: 'The payouts could not be fetched.',
                code: $exception->getCode(),
                previous: $exception
            );
        }

        return $response;
    }

    // create payout
    public function create(): array {}

    // create or update payout link
    public function createOrUpdateLink($id): array {}

    // delete payout link
    public function delete($id): array {}

    // get single payout
    public function find($id): array {}

    // update payout
    public function update($id): array {}

    // authorize a payout
    public function authorize($id): array {}
}
