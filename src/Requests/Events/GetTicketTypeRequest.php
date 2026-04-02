<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Responses\TicketTypeResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTicketTypeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/ticket-types/get';
    }

    protected function defaultQuery(): array
    {
        return ['id' => $this->id];
    }

    public function createDtoFromResponse(Response $response): TicketTypeResponse
    {
        /** @var array{ticket_type: array<string, mixed>} $data */
        $data = $response->json();

        return TicketTypeResponse::fromArray($data['ticket_type']);
    }
}
