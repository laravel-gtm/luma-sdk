<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Enums\ApprovalStatus;
use LaravelGtm\LumaSdk\Enums\SortDirection;
use LaravelGtm\LumaSdk\Responses\GuestResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListGuestsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $eventId,
        private readonly ?ApprovalStatus $approvalStatus = null,
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
        private readonly ?string $sortColumn = null,
        private readonly ?SortDirection $sortDirection = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/get-guests';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'event_id' => $this->eventId,
            'approval_status' => $this->approvalStatus?->value,
            'pagination_cursor' => $this->paginationCursor,
            'pagination_limit' => $this->paginationLimit,
            'sort_column' => $this->sortColumn,
            'sort_direction' => $this->sortDirection?->value,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<GuestResponse>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return PaginatedResponse::fromArray(
            $data,
            fn (array $entry): GuestResponse => GuestResponse::fromArray((array) $entry['guest']),
        );
    }
}
