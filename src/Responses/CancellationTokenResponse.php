<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class CancellationTokenResponse
{
    public function __construct(
        public readonly string $cancellationToken,
        public readonly bool $isPaid,
        public readonly int $guestCount,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            cancellationToken: (string) $data['cancellation_token'],
            isPaid: (bool) $data['is_paid'],
            guestCount: (int) $data['guest_count'],
        );
    }
}
