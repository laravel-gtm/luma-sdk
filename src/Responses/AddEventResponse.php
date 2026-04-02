<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class AddEventResponse
{
    public function __construct(
        public string $apiId,
        public string $status,
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
