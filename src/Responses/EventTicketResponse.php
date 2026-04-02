<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

class EventTicketResponse
{
    public function __construct(
        public readonly string $id,
        public readonly ?int $amount,
        public readonly ?int $amountDiscount,
        public readonly ?int $amountTax,
        public readonly ?string $currency,
        public readonly ?LumaDate $checkedInAt,
        public readonly ?string $eventTicketTypeId,
        public readonly ?bool $isCaptured,
        public readonly ?string $name,
        public readonly ?string $apiId,
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
