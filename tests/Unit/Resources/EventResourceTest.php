<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Events\CreateEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListTicketTypesRequest;
use LaravelGtm\LumaSdk\Responses\EventResponse;
use LaravelGtm\LumaSdk\Responses\GetEventResponse;
use LaravelGtm\LumaSdk\Responses\HostResponse;
use LaravelGtm\LumaSdk\Responses\TicketTypeResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

beforeEach(function (): void {
    $refl = new ReflectionProperty(MemoryStore::class, 'store');
    $refl->setValue(null, []);
});

it('gets an event with hosts', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        GetEventRequest::class => MockResponse::make([
            'event' => [
                'id' => 'evt_123',
                'name' => 'Test Event',
                'start_at' => '2024-06-15T18:00:00.000Z',
                'created_at' => '2024-06-01T10:00:00.000Z',
                'url' => 'https://lu.ma/test',
            ],
            'hosts' => [
                [
                    'id' => 'usr_1',
                    'email' => 'host@example.test',
                    'name' => 'Host User',
                    'first_name' => 'Host',
                    'last_name' => 'User',
                    'avatar_url' => 'https://example.test/avatar.jpg',
                    'api_id' => 'usr_1',
                ],
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->events()->get('evt_123');

    expect($response)->toBeInstanceOf(GetEventResponse::class);
    expect($response->event)->toBeInstanceOf(EventResponse::class);
    expect($response->event->name)->toBe('Test Event');
    expect($response->hosts)->toHaveCount(1);
    expect($response->hosts[0])->toBeInstanceOf(HostResponse::class);
    expect($response->hosts[0]->name)->toBe('Host User');

    $mockClient->assertSent(GetEventRequest::class);
});

it('creates an event and returns api id', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CreateEventRequest::class => MockResponse::make([
            'api_id' => 'evt_new_123',
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $apiId = $sdk->events()->create(new CreateEventRequest(
        name: 'New Event',
        startAt: '2024-06-15T18:00:00.000Z',
        timezone: 'America/New_York',
    ));

    expect($apiId)->toBe('evt_new_123');
    $mockClient->assertSent(CreateEventRequest::class);
});

it('lists ticket types for an event', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        ListTicketTypesRequest::class => MockResponse::make([
            'ticket_types' => [
                [
                    'id' => 'tt_1',
                    'name' => 'General Admission',
                    'require_approval' => false,
                    'is_hidden' => false,
                    'type' => 'free',
                    'api_id' => 'tt_1',
                ],
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $types = $sdk->events()->listTicketTypes('evt_123');

    expect($types)->toHaveCount(1);
    expect($types[0])->toBeInstanceOf(TicketTypeResponse::class);
    expect($types[0]->name)->toBe('General Admission');

    $mockClient->assertSent(ListTicketTypesRequest::class);
});
