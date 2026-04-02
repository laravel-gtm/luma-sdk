<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class UserResponse
{
    public function __construct(
        public string $id,
        public ?string $name,
        public string $avatarUrl,
        public string $email,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $apiId = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (string) $data['id'],
            name: isset($data['name']) ? (string) $data['name'] : null,
            avatarUrl: (string) $data['avatar_url'],
            email: (string) $data['email'],
            firstName: isset($data['first_name']) ? (string) $data['first_name'] : null,
            lastName: isset($data['last_name']) ? (string) $data['last_name'] : null,
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
        );
    }
}
