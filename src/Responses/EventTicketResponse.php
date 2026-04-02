<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

readonly class EventTicketResponse
{
    public function __construct(
        public string $id,
        public ?int $amount,
        public ?int $amountDiscount,
        public ?int $amountTax,
        public ?string $currency,
        public ?LumaDate $checkedInAt,
        public ?string $eventTicketTypeId,
        public ?bool $isCaptured,
        public ?string $name,
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
            checkedInAt: isset($data['checked_in_at']) ? LumaDate::fromString((string) $data['checked_in_at']) : null,
            eventTicketTypeId: isset($data['event_ticket_type_id']) ? (string) $data['event_ticket_type_id'] : null,
            isCaptured: isset($data['is_captured']) ? (bool) $data['is_captured'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
        );
    }
}
