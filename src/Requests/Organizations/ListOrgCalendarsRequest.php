<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Organizations;

use LaravelGtm\LumaSdk\Responses\CalendarResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListOrgCalendarsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/organizations/calendars/list';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'pagination_cursor' => $this->paginationCursor,
            'pagination_limit' => $this->paginationLimit,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<CalendarResponse>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return PaginatedResponse::fromArray($data, CalendarResponse::fromArray(...));
    }
}
