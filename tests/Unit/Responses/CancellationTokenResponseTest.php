<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\CancellationTokenResponse;

it('creates from array', function (): void {
    $response = CancellationTokenResponse::fromArray([
        'cancellation_token' => 'cancel_abc',
        'is_paid' => true,
        'guest_count' => 42,
    ]);

    expect($response->cancellationToken)->toBe('cancel_abc');
    expect($response->isPaid)->toBeTrue();
    expect($response->guestCount)->toBe(42);
});
