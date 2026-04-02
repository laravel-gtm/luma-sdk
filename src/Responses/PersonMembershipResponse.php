<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

use LaravelGtm\LumaSdk\Enums\MemberStatus;

readonly class PersonMembershipResponse
{
    public function __construct(
        public MemberStatus $status,
        public ?string $calendarMembershipTierId,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: MemberStatus::from((string) $data['status']),
            calendarMembershipTierId: isset($data['calendar_membership_tier_id']) ? (string) $data['calendar_membership_tier_id'] : null,
        );
    }
}
