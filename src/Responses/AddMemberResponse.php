<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class AddMemberResponse
{
    public function __construct(
        public readonly string $membershipId,
        public readonly string $status,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            membershipId: (string) $data['membership_id'],
            status: (string) $data['status'],
        );
    }
}
