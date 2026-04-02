<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\TagResponse;

it('creates a paginated response from array', function (): void {
    $response = PaginatedResponse::fromArray(
        [
            'entries' => [
                ['api_id' => 'tag_1', 'name' => 'VIP', 'color' => '#ff0000'],
                ['api_id' => 'tag_2', 'name' => 'Speaker'],
            ],
            'has_more' => true,
            'next_cursor' => 'cursor_abc',
        ],
        TagResponse::fromArray(...),
    );

    expect($response->entries)->toHaveCount(2);
    expect($response->entries[0])->toBeInstanceOf(TagResponse::class);
    expect($response->entries[0]->name)->toBe('VIP');
    expect($response->hasMore)->toBeTrue();
    expect($response->nextCursor)->toBe('cursor_abc');
});

it('handles empty paginated response', function (): void {
    $response = PaginatedResponse::fromArray(
        ['entries' => [], 'has_more' => false],
        TagResponse::fromArray(...),
    );

    expect($response->entries)->toBeEmpty();
    expect($response->hasMore)->toBeFalse();
    expect($response->nextCursor)->toBeNull();
});
