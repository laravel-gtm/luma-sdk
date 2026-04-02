<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\Responses\UserResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class ListCalendarAdminsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/admins/list';
    }

    /**
     * @return UserResponse[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array{entries: array<int, array<string, mixed>>} $data */
        $data = $response->json();

        return array_map(UserResponse::fromArray(...), $data['entries']);
    }
}
