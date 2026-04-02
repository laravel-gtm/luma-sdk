<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class EventTicketOrderResponse
{
    public function __construct(
        public string $id,
        public ?int $amount,
        public ?int $amountDiscount,
        public ?int $amountTax,
        public ?string $currency,
        public ?bool $isCaptured,
        public ?string $apiId,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            amount: isset($data['amount']) ? (int) $data['amount'] : null,
            amountDiscount: isset($data['amount_discount']) ? (int) $data['amount_discount'] : null,
            amountTax: isset($data['amount_tax']) ? (int) $data['amount_tax'] : null,
            currency: isset($data['currency']) ? (string) $data['currency'] : null,
            isCaptured: isset($data['is_captured']) ? (bool) $data['is_captured'] : null,
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
        );
    }
}
