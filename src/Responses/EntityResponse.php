<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\EntityType;

readonly class EntityResponse
{
    public function __construct(
        public EntityType $type,
        public ?CalendarResponse $calendar,
        public ?EventResponse $event,
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
