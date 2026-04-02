<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

readonly class TagRemoveResponse
{
    public function __construct(
        public int $removedCount,
        public int $skippedCount,
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
