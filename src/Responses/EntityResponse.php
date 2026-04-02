<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\EntityType;

class EntityResponse
{
    /**
     * @param  array<string, mixed>|null  $calendar
     * @param  array<string, mixed>|null  $event
     */
    public function __construct(
        public readonly EntityType $type,
        public readonly ?array $calendar,
        public readonly ?array $event,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: EntityType::from((string) $data['type']),
            calendar: isset($data['calendar']) ? (array) $data['calendar'] : null,
            event: isset($data['event']) ? (array) $data['event'] : null,
        );
    }
}
