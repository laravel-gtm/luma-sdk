<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Responses\GetEventResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Retrieves an event by API ID.
 *
 * `GET /v1/event/get`
 */
class GetEventRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/get';
    }

    protected function defaultQuery(): array
    {
        return ['id' => $this->id];
    }

    public function createDtoFromResponse(Response $response): GetEventResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return GetEventResponse::fromArray($data);
    }
}
