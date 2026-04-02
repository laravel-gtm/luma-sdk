<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Responses\TicketTypeResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListTicketTypesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $eventId,
        private readonly ?string $includeHidden = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/ticket-types/list';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'event_id' => $this->eventId,
            'include_hidden' => $this->includeHidden,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return TicketTypeResponse[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array{ticket_types: array<int, array<string, mixed>>} $data */
        $data = $response->json();

        return array_map(TicketTypeResponse::fromArray(...), $data['ticket_types']);
    }
}
