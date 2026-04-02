<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\TagActionResponse;

it('creates from array', function (): void {
    $response = TagActionResponse::fromArray([
        'applied_count' => 5,
        'skipped_count' => 2,
    ]);

    expect($response->appliedCount)->toBe(5);
    expect($response->skippedCount)->toBe(2);
});
