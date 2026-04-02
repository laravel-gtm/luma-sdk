<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\Enums\SortDirection;
use LaravelGtm\LumaSdk\Responses\CalendarEventEntry;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Lists calendar events.
 *
 * `GET /v1/calendar/list-events`
 */
class ListCalendarEventsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $before = null,
        private readonly ?string $after = null,
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
        private readonly ?string $sortColumn = null,
        private readonly ?SortDirection $sortDirection = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/list-events';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'before' => $this->before,
            'after' => $this->after,
            'pagination_cursor' => $this->paginationCursor,
            'pagination_limit' => $this->paginationLimit,
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection?->value,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<CalendarEventEntry>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return PaginatedResponse::fromArray($data, CalendarEventEntry::fromArray(...));
    }
}
