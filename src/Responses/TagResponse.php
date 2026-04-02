<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class TagResponse
{
    public function __construct(
        public readonly string $apiId,
        public readonly string $name,
        public readonly ?string $color = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            apiId: (string) ($data['api_id'] ?? $data['id'] ?? ''),
            name: (string) $data['name'],
            color: isset($data['color']) ? (string) $data['color'] : null,
        );
    }
}
