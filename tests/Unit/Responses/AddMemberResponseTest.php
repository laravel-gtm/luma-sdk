<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\AddMemberResponse;

it('creates from array', function (): void {
    $response = AddMemberResponse::fromArray([
        'membership_id' => 'mem_123',
        'status' => 'approved',
    ]);

    expect($response->membershipId)->toBe('mem_123');
    expect($response->status)->toBe('approved');
});
