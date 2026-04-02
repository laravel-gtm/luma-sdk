<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\WebhookStatus;
use LaravelGtm\LumaSdk\Responses\WebhookResponse;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

it('creates a webhook response from array', function (): void {
    $response = WebhookResponse::fromArray([
        'id' => 'wh_123',
        'url' => 'https://example.test/webhook',
        'event_types' => ['event.created', 'guest.registered'],
        'status' => 'active',
        'secret' => 'whsec_abc123',
        'created_at' => '2024-06-01T10:00:00.000Z',
    ]);

    expect($response->id)->toBe('wh_123');
    expect($response->url)->toBe('https://example.test/webhook');
    expect($response->eventTypes)->toBe(['event.created', 'guest.registered']);
    expect($response->status)->toBe(WebhookStatus::Active);
    expect($response->secret)->toBe('whsec_abc123');
    expect($response->createdAt)->toBeInstanceOf(LumaDate::class);
});
