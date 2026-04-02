<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateCalendarCouponRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $code,
        private readonly ?int $remainingCount = null,
        private readonly ?LumaDate $validStartAt = null,
        private readonly ?LumaDate $validEndAt = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/coupons/update';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'code' => $this->code,
            'remaining_count' => $this->remainingCount,
            'valid_start_at' => $this->validStartAt?->toString(),
            'valid_end_at' => $this->validEndAt?->toString(),
        ], fn (mixed $value): bool => $value !== null);
    }
}
