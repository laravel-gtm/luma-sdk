<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

/**
 * @template T
 */
readonly class PaginatedResponse
{
    /**
     * @param  T[]  $entries
     */
    public function __construct(
        public array $entries,
        public bool $hasMore = false,
        public ?string $nextCursor = null,
    ) {}

    /**
     * @template TEntry
     *
     * @param  array<string, mixed>  $data
     * @param  callable(array<string, mixed>): TEntry  $map
     * @return self<TEntry>
     */
    public static function fromArray(array $data, callable $map): self
    {
        return new self(
            entries: array_map($map, (array) ($data['entries'] ?? [])),
            hasMore: (bool) ($data['has_more'] ?? false),
            nextCursor: isset($data['next_cursor']) ? (string) $data['next_cursor'] : null,
        );
    }
}
