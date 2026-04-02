<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class UserResponse
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name,
        public readonly string $avatarUrl,
        public readonly string $email,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
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
        );
    }
}
