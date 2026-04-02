<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class TagRemoveResponse
{
    public function __construct(
        public readonly int $removedCount,
        public readonly int $skippedCount,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            removedCount: (int) $data['removed_count'],
            skippedCount: (int) $data['skipped_count'],
        );
    }
}
