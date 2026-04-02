<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use LaravelGtm\LumaSdk\Responses\CalendarResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Retrieves a calendar.
 *
 * `GET /v1/calendar/get`
 */
class GetCalendarRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/get';
    }

    public function createDtoFromResponse(Response $response): CalendarResponse
    {
        /** @var array{calendar: array<string, mixed>} $data */
        $data = $response->json();

        return CalendarResponse::fromArray($data['calendar']);
    }
}
