<?php

namespace Netbums\Quickpay\DataObjects;

readonly class OptionalAddress
{
    public function __construct(
        public ?string $name,
        public ?string $att,
        public ?string $company_name,
        public ?string $street,
        public ?string $house_number,
        public ?string $house_extension,
        public ?string $city,
        public ?string $zip_code,
        public ?string $region,
        public ?string $country_code,
        public ?string $vat_no,
        public ?string $phone_number,
        public ?string $mobile_number,
        public ?string $email,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'] ?? null,
            att: $data['att'] ?? null,
            company_name: $data['company_name'] ?? null,
            street: $data['street'] ?? null,
            house_number: $data['house_number'] ?? null,
            house_extension: $data['house_extension'] ?? null,
            city: $data['city'] ?? null,
            zip_code: $data['zip_code'] ?? null,
            region: $data['region'] ?? null,
            country_code: $data['country_code'] ?? null,
            vat_no: $data['vat_no'] ?? null,
            phone_number: $data['phone_number'] ?? null,
            mobile_number: $data['mobile_number'] ?? null,
            email: $data['email'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'att' => $this->att,
            'company_name' => $this->company_name,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'house_extension' => $this->house_extension,
            'city' => $this->city,
            'zip_code' => $this->zip_code,
            'region' => $this->region,
            'country_code' => $this->country_code,
            'vat_no' => $this->vat_no,
            'phone_number' => $this->phone_number,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
        ];
    }
}
