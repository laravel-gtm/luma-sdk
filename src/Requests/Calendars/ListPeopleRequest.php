<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\Enums\MemberStatus;
use LaravelGtm\LumaSdk\Enums\SortDirection;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\PersonResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListPeopleRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $search = null,
        private readonly ?string $tags = null,
        private readonly ?string $calendarMembershipTierId = null,
        private readonly ?MemberStatus $memberStatus = null,
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
        private readonly ?string $sortColumn = null,
        private readonly ?SortDirection $sortDirection = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/list-people';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'query' => $this->search,
            'tags' => $this->tags,
            'calendar_membership_tier_id' => $this->calendarMembershipTierId,
            'member_status' => $this->memberStatus?->value,
            'pagination_cursor' => $this->paginationCursor,
            'pagination_limit' => $this->paginationLimit,
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection?->value,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<PersonResponse>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return PaginatedResponse::fromArray($data, PersonResponse::fromArray(...));
    }
}
