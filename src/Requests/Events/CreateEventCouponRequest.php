<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateEventCouponRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array{discount_type: string, percent_off?: float}|array{discount_type: string, cents_off: int, currency: string}  $discount
     */
    public function __construct(
        private readonly string $eventApiId,
        private readonly string $code,
        private readonly array $discount,
        private readonly ?int $remainingCount = null,
        private readonly ?LumaDate $validStartAt = null,
        private readonly ?LumaDate $validEndAt = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/create-coupon';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'event_api_id' => $this->eventApiId,
            'code' => $this->code,
            'discount' => $this->discount,
            'remaining_count' => $this->remainingCount,
            'valid_start_at' => $this->validStartAt?->toString(),
            'valid_end_at' => $this->validEndAt?->toString(),
        ], fn (mixed $value): bool => $value !== null);
    }
}
