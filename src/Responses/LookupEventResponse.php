<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class LookupEventResponse
{
    public function __construct(
        public readonly ?string $apiId,
        public readonly ?string $status,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
            status: isset($data['status']) ? (string) $data['status'] : null,
        );
    }
}
