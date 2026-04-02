<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class TagActionResponse
{
    public function __construct(
        public readonly int $appliedCount,
        public readonly int $skippedCount,
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
