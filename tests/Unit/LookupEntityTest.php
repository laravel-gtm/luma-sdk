<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\EntityType;
use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\LookupEntityRequest;
use LaravelGtm\LumaSdk\Responses\EntityResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

it('looks up an entity by slug', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        LookupEntityRequest::class => MockResponse::make([
            'entity' => [
                'type' => 'event',
                'event' => [
                    'api_id' => 'evt_123',
                    'name' => 'Found Event',
                    'slug' => 'found-event',
                    'cover_url' => 'https://example.test/cover.jpg',
                    'start_at' => '2024-06-15T18:00:00.000Z',
                    'end_at' => '2024-06-15T20:00:00.000Z',
                ],
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $entity = $sdk->lookupEntity('found-event');

    expect($entity)->toBeInstanceOf(EntityResponse::class);
    expect($entity->type)->toBe(EntityType::Event);
    expect($entity->event)->not->toBeNull();
    expect($entity->calendar)->toBeNull();

    $mockClient->assertSent(LookupEntityRequest::class);
});
