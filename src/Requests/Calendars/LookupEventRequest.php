<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\Responses\LookupEventResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class LookupEventRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $platform = null,
        private readonly ?string $url = null,
        private readonly ?string $eventApiId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/lookup-event';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'platform' => $this->platform,
            'url' => $this->url,
            'event_api_id' => $this->eventApiId,
        ], fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): LookupEventResponse
    {
        /** @var array{event: array<string, mixed>|null} $data */
        $data = $response->json();

        if ($data['event'] === null) {
            return new LookupEventResponse(apiId: null, status: null);
        }

        return LookupEventResponse::fromArray($data['event']);
    }
}
