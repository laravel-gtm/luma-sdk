<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class MembershipTierResponse
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public ?string $tintColor,
        public AccessInfoResponse $accessInfo,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            name: (string) $data['name'],
            description: isset($data['description']) ? (string) $data['description'] : null,
            tintColor: isset($data['tint_color']) ? (string) $data['tint_color'] : null,
            accessInfo: AccessInfoResponse::fromArray((array) $data['access_info']),
        );
    }
}
