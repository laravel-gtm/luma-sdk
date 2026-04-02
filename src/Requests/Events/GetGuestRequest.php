<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Responses\GuestResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Retrieves an event guest by API ID.
 *
 * `GET /v1/event/get-guest`
 */
class GetGuestRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $eventId = null,
        private readonly ?string $id = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/get-guest';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'event_id' => $this->eventId,
            'id' => $this->id,
        ], fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): GuestResponse
    {
        /** @var array{guest: array<string, mixed>} $data */
        $data = $response->json();

        return GuestResponse::fromArray($data['guest']);
    }
}
