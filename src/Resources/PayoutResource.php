<?php

namespace Netbums\Quickpay\Resources;

use Netbums\Quickpay\Resources\Concerns\QuickpayApiConsumer;

class PayoutResource
{
    use QuickpayApiConsumer;

    // get payouts
    public function all(): array {}

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
