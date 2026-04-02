<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class TagActionResponse
{
    public function __construct(
        public int $appliedCount,
        public int $skippedCount,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            appliedCount: (int) $data['applied_count'],
            skippedCount: (int) $data['skipped_count'],
        );
    }
}
