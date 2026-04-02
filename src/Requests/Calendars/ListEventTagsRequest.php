<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\Responses\TagResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Lists calendar event tags.
 *
 * `GET /v1/calendar/event-tags/list`
 */
class ListEventTagsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/event-tags/list';
    }

    /**
     * @return TagResponse[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array{entries: array<int, array<string, mixed>>} $data */
        $data = $response->json();

        return array_map(TagResponse::fromArray(...), $data['entries']);
    }
}
