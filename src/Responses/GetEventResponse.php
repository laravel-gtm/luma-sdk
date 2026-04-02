<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class GetEventResponse
{
    /**
     * @param  HostResponse[]  $hosts
     */
    public function __construct(
        public EventResponse $event,
        public array $hosts,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            event: EventResponse::fromArray((array) $data['event']),
            hosts: array_map(HostResponse::fromArray(...), (array) ($data['hosts'] ?? [])),
        );
    }
}
