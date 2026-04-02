<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Responses\CouponResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListEventCouponsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $eventId,
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/coupons';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'event_id' => $this->eventId,
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
