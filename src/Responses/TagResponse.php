<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class TagResponse
{
    public function __construct(
        public string $apiId,
        public string $name,
        public ?string $color = null,
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
