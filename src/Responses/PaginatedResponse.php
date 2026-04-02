<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

/**
 * @template T
 */
class PaginatedResponse
{
    /**
     * @param  T[]  $entries
     */
    public function __construct(
        public readonly array $entries,
        public readonly bool $hasMore = false,
        public readonly ?string $nextCursor = null,
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
