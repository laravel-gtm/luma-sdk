<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Applies an event tag to events.
 *
 * `POST /v1/calendar/event-tags/apply`
 */
class ApplyEventTagRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string[]  $eventApiIds
     */
    public function __construct(
        private readonly string $tag,
        private readonly array $eventApiIds,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/event-tags/apply';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'tag' => $this->tag,
            'event_api_ids' => $this->eventApiIds,
        ];
    }
}
