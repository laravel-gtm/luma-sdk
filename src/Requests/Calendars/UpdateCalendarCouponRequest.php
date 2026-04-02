<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

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
        private readonly ?string $validStartAt = null,
        private readonly ?string $validEndAt = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/coupons/update';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'code' => $this->code,
            'remaining_count' => $this->remainingCount,
            'valid_start_at' => $this->validStartAt,
            'valid_end_at' => $this->validEndAt,
        ], fn (mixed $value): bool => $value !== null);
    }
}
