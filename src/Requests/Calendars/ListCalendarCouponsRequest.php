<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\Responses\CouponResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Lists calendar coupons.
 *
 * `GET /v1/calendar/coupons`
 */
class ListCalendarCouponsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/coupons';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'pagination_cursor' => $this->paginationCursor,
            'pagination_limit' => $this->paginationLimit,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<CouponResponse>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return PaginatedResponse::fromArray($data, CouponResponse::fromArray(...));
    }
}
