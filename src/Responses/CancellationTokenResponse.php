<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class CancellationTokenResponse
{
    public function __construct(
        public string $cancellationToken,
        public bool $isPaid,
        public int $guestCount,
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
