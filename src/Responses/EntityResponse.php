<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\EntityType;

class EntityResponse
{
    public function __construct(
        public readonly EntityType $type,
        public readonly ?CalendarResponse $calendar,
        public readonly ?EventResponse $event,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: EntityType::from((string) $data['type']),
            calendar: isset($data['calendar']) ? CalendarResponse::fromArray((array) $data['calendar']) : null,
            event: isset($data['event']) ? EventResponse::fromArray((array) $data['event']) : null,
        );
    }
}
