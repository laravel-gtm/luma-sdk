<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class AddMemberResponse
{
    public function __construct(
        public string $membershipId,
        public string $status,
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
