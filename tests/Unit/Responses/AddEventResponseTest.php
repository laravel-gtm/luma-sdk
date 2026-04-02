<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\AddEventResponse;

it('creates from array', function (): void {
    $response = AddEventResponse::fromArray([
        'api_id' => 'evt_123',
        'status' => 'approved',
    ]);

    expect($response->apiId)->toBe('evt_123');
    expect($response->status)->toBe('approved');
});
