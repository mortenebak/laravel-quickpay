<?php

namespace Netbums\Quickpay\DataObjects;

readonly class PaymentLink
{
    public function __construct(
        public int $id, // transaction id
        public int $amount, // Amount to authorize
        public ?string $language = null,
        public ?string $continue_url = null,
        public ?string $cancel_url = null,
        public ?string $callback_url = null,
        public ?bool $auto_capture = null,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id: $data['id'],
            amount: $data['amount'],
            language: $data['language'] ?? null,
            continue_url: $data['continue_url'] ?? null,
            cancel_url: $data['cancel_url'] ?? null,
            callback_url: $data['callback_url'] ?? null,
            auto_capture: $data['auto_capture'] ?? null,
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
            'auto_capture' => $this->auto_capture,
        ];
    }
}
