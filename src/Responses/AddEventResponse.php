<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class AddEventResponse
{
    public function __construct(
        public readonly string $apiId,
        public readonly string $status,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            apiId: (string) $data['api_id'],
            status: (string) $data['status'],
        );
    }
}
