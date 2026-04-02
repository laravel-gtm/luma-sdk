<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class HostResponse
{
    public function __construct(
        public string $id,
        public ?string $email,
        public ?string $name,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $avatarUrl,
        public ?string $apiId,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            email: isset($data['email']) ? (string) $data['email'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            firstName: isset($data['first_name']) ? (string) $data['first_name'] : null,
            lastName: isset($data['last_name']) ? (string) $data['last_name'] : null,
            avatarUrl: isset($data['avatar_url']) ? (string) $data['avatar_url'] : null,
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
        );
    }
}
