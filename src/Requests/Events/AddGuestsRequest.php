<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class AddGuestsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<array{email: string, name?: string|null}>  $guests
     * @param  array{event_ticket_type_id: string}|null  $ticket
     * @param  array<array{event_ticket_type_id: string}>|null  $tickets
     */
    public function __construct(
        private readonly string $eventApiId,
        private readonly array $guests,
        private readonly ?array $ticket = null,
        private readonly ?array $tickets = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/add-guests';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'event_api_id' => $this->eventApiId,
            'guests' => $this->guests,
            'ticket' => $this->ticket,
            'tickets' => $this->tickets,
        ], fn (mixed $value): bool => $value !== null);
    }
}
