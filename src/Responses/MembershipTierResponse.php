<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class MembershipTierResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $tintColor,
        public readonly AccessInfoResponse $accessInfo,
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
