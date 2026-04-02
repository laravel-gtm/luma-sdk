<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Webhooks\CreateWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\DeleteWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\GetWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\ListWebhooksRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\UpdateWebhookRequest;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\WebhookResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

beforeEach(function (): void {
    $refl = new ReflectionProperty(MemoryStore::class, 'store');
    $refl->setValue(null, []);
});

it('gets a webhook by id', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        GetWebhookRequest::class => MockResponse::make([
            'webhook' => [
                'id' => 'wh_123',
                'url' => 'https://example.test/webhook',
                'event_types' => ['event.created'],
                'status' => 'active',
                'secret' => 'whsec_abc',
                'created_at' => '2024-06-01T10:00:00.000Z',
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $webhook = $sdk->webhooks()->get('wh_123');

    expect($webhook)->toBeInstanceOf(WebhookResponse::class);
    expect($webhook->id)->toBe('wh_123');
    expect($webhook->url)->toBe('https://example.test/webhook');

    $mockClient->assertSent(GetWebhookRequest::class);
});

it('creates a webhook', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CreateWebhookRequest::class => MockResponse::make([
            'webhook' => [
                'id' => 'wh_new',
                'url' => 'https://example.test/new-hook',
                'event_types' => ['event.created'],
                'status' => 'active',
                'secret' => 'whsec_new',
                'created_at' => '2024-06-01T10:00:00.000Z',
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $webhook = $sdk->webhooks()->create('https://example.test/new-hook', ['event.created']);

    expect($webhook)->toBeInstanceOf(WebhookResponse::class);
    expect($webhook->id)->toBe('wh_new');
    expect($webhook->url)->toBe('https://example.test/new-hook');
});

it('updates a webhook', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        UpdateWebhookRequest::class => MockResponse::make([
            'webhook' => [
                'id' => 'wh_123',
                'url' => 'https://example.test/webhook',
                'event_types' => ['event.created', 'event.updated'],
                'status' => 'active',
                'secret' => 'whsec_abc',
                'created_at' => '2024-06-01T10:00:00.000Z',
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $webhook = $sdk->webhooks()->update(new UpdateWebhookRequest(
        id: 'wh_123',
        eventTypes: ['event.created', 'event.updated'],
    ));

    expect($webhook)->toBeInstanceOf(WebhookResponse::class);
    expect($webhook->eventTypes)->toHaveCount(2);
});

it('deletes a webhook', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        DeleteWebhookRequest::class => MockResponse::make([]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $sdk->webhooks()->delete('wh_123');

    $mockClient->assertSent(DeleteWebhookRequest::class);
});

it('lists webhooks with pagination', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        ListWebhooksRequest::class => MockResponse::make([
            'entries' => [
                [
                    'id' => 'wh_1',
                    'url' => 'https://example.test/wh1',
                    'event_types' => ['*'],
                    'status' => 'active',
                    'secret' => 'sec_1',
                    'created_at' => '2024-06-01T10:00:00.000Z',
                ],
            ],
            'has_more' => false,
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->webhooks()->list();

    expect($response)->toBeInstanceOf(PaginatedResponse::class);
    expect($response->entries)->toHaveCount(1);
    expect($response->hasMore)->toBeFalse();

    $mockClient->assertSent(ListWebhooksRequest::class);
});
