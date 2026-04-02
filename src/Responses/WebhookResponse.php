<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\WebhookStatus;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

class WebhookResponse
{
    /**
     * @param  string[]  $eventTypes
     */
    public function __construct(
        public readonly string $id,
        public readonly string $url,
        public readonly array $eventTypes,
        public readonly WebhookStatus $status,
        public readonly string $secret,
        public readonly LumaDate $createdAt,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            url: (string) $data['url'],
            eventTypes: array_map(strval(...), (array) $data['event_types']),
            status: WebhookStatus::from((string) $data['status']),
            secret: (string) $data['secret'],
            createdAt: LumaDate::fromString((string) $data['created_at']),
        );
    }
}
