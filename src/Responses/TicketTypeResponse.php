<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\TicketPriceType;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

readonly class TicketTypeResponse
{
    /**
     * @param  array<mixed>  $ethereumTokenRequirements
     */
    public function __construct(
        public string $id,
        public string $name,
        public bool $requireApproval,
        public bool $isHidden,
        public ?string $description,
        public ?LumaDate $validStartAt,
        public ?LumaDate $validEndAt,
        public ?int $maxCapacity,
        public ?string $membershipRestriction,
        public array $ethereumTokenRequirements,
        public TicketPriceType $type,
        public ?int $cents,
        public ?string $currency,
        public ?bool $isFlexible,
        public ?int $minCents,
        public ?string $apiId,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            name: (string) $data['name'],
            requireApproval: (bool) ($data['require_approval'] ?? false),
            isHidden: (bool) ($data['is_hidden'] ?? false),
            description: isset($data['description']) ? (string) $data['description'] : null,
            validStartAt: isset($data['valid_start_at']) ? LumaDate::fromString((string) $data['valid_start_at']) : null,
            validEndAt: isset($data['valid_end_at']) ? LumaDate::fromString((string) $data['valid_end_at']) : null,
            maxCapacity: isset($data['max_capacity']) ? (int) $data['max_capacity'] : null,
            membershipRestriction: isset($data['membership_restriction']) ? (string) $data['membership_restriction'] : null,
            ethereumTokenRequirements: (array) ($data['ethereum_token_requirements'] ?? []),
            type: TicketPriceType::from((string) $data['type']),
            cents: isset($data['cents']) ? (int) $data['cents'] : null,
            currency: isset($data['currency']) ? (string) $data['currency'] : null,
            isFlexible: isset($data['is_flexible']) ? (bool) $data['is_flexible'] : null,
            minCents: isset($data['min_cents']) ? (int) $data['min_cents'] : null,
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
        );
    }
}
