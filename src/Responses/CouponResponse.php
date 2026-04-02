<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

class CouponResponse
{
    public function __construct(
        public readonly string $apiId,
        public readonly string $code,
        public readonly ?int $remainingCount,
        public readonly ?LumaDate $validStartAt,
        public readonly ?LumaDate $validEndAt,
        public readonly ?float $percentOff,
        public readonly ?int $centsOff,
        public readonly ?string $currency,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            apiId: (string) $data['api_id'],
            code: (string) $data['code'],
            remainingCount: isset($data['remaining_count']) ? (int) $data['remaining_count'] : null,
            validStartAt: isset($data['valid_start_at']) ? LumaDate::fromString((string) $data['valid_start_at']) : null,
            validEndAt: isset($data['valid_end_at']) ? LumaDate::fromString((string) $data['valid_end_at']) : null,
            percentOff: isset($data['percent_off']) ? (float) $data['percent_off'] : null,
            centsOff: isset($data['cents_off']) ? (int) $data['cents_off'] : null,
            currency: isset($data['currency']) ? (string) $data['currency'] : null,
        );
    }
}
