<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

readonly class PersonResponse
{
    /**
     * @param  TagResponse[]  $tags
     */
    public function __construct(
        public string $id,
        public ?string $email,
        public LumaDate $createdAt,
        public int $eventApprovedCount,
        public int $eventCheckedInCount,
        public int $revenueUsdCents,
        public array $tags,
        public UserResponse $user,
        public ?PersonMembershipResponse $membership,
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
            createdAt: LumaDate::fromString((string) $data['created_at']),
            eventApprovedCount: (int) ($data['event_approved_count'] ?? 0),
            eventCheckedInCount: (int) ($data['event_checked_in_count'] ?? 0),
            revenueUsdCents: (int) ($data['revenue_usd_cents'] ?? 0),
            tags: array_map(TagResponse::fromArray(...), (array) ($data['tags'] ?? [])),
            user: UserResponse::fromArray((array) $data['user']),
            membership: isset($data['membership']) ? PersonMembershipResponse::fromArray((array) $data['membership']) : null,
            apiId: isset($data['api_id']) ? (string) $data['api_id'] : null,
        );
    }
}
