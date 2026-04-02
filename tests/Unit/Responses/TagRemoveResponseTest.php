<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\TagRemoveResponse;

it('creates from array', function (): void {
    $response = TagRemoveResponse::fromArray([
        'removed_count' => 3,
        'skipped_count' => 1,
    ]);

    expect($response->removedCount)->toBe(3);
    expect($response->skippedCount)->toBe(1);
});
