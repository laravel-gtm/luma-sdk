<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class CalendarEventEntry
{
    /**
     * @param  TagResponse[]  $tags
     */
    public function __construct(
        public readonly ?string $apiId,
        public readonly EventResponse $event,
        public readonly array $tags,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
            event: EventResponse::fromArray((array) $data['event']),
            tags: array_map(TagResponse::fromArray(...), (array) ($data['tags'] ?? [])),
        );
    }
}
