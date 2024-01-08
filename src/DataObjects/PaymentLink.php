<?php

namespace Netbums\Quickpay\DataObjects;

readonly class PaymentLink
{

    public function __construct(
        public int     $id, // transaction id
        public int     $amount, // Amount to authorize
        public ?string $language,
        public ?string $continue_url,
        public ?string $cancel_url,
        public ?string $callback_url,
    )
    {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            id: $data['id'],
            amount: $data['amount'],
            language: $data['language'],
            continue_url: $data['continue_url'],
            cancel_url: $data['cancel_url'],
            callback_url: $data['callback_url'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'language' => $this->language,
            'continue_url' => $this->continue_url,
            'cancel_url' => $this->cancel_url,
            'callback_url' => $this->callback_url,
        ];
    }

}
