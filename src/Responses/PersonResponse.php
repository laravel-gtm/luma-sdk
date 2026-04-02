<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

class PersonResponse
{
    /**
     * @param  TagResponse[]  $tags
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $email,
        public readonly LumaDate $createdAt,
        public readonly int $eventApprovedCount,
        public readonly int $eventCheckedInCount,
        public readonly int $revenueUsdCents,
        public readonly array $tags,
        public readonly UserResponse $user,
        public readonly ?PersonMembershipResponse $membership,
        public readonly ?string $apiId,
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
