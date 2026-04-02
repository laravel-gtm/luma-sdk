<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Events\CancelEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\CreateEventCouponRequest;
use LaravelGtm\LumaSdk\Requests\Events\CreateEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\CreateTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\DeleteTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListTicketTypesRequest;
use LaravelGtm\LumaSdk\Requests\Events\RequestCancellationRequest;
use LaravelGtm\LumaSdk\Responses\CancellationTokenResponse;
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

it('requests event cancellation', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        RequestCancellationRequest::class => MockResponse::make([
            'cancellation_token' => 'cancel_abc',
            'is_paid' => true,
            'guest_count' => 5,
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->events()->requestCancellation('evt_123');

    expect($response)->toBeInstanceOf(CancellationTokenResponse::class);
    expect($response->cancellationToken)->toBe('cancel_abc');
    expect($response->isPaid)->toBeTrue();
    expect($response->guestCount)->toBe(5);
});

it('cancels an event', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CancelEventRequest::class => MockResponse::make([]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $sdk->events()->cancel('evt_123', 'cancel_abc');

    $mockClient->assertSent(CancelEventRequest::class);
});

it('creates an event coupon and returns api id', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CreateEventCouponRequest::class => MockResponse::make([
            'coupon' => ['api_id' => 'cpn_123'],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $apiId = $sdk->events()->createCoupon(new CreateEventCouponRequest(
        eventApiId: 'evt_123',
        code: 'SAVE20',
        discount: ['discount_type' => 'percent', 'percent_off' => 20],
    ));

    expect($apiId)->toBe('cpn_123');
});

it('creates a ticket type', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CreateTicketTypeRequest::class => MockResponse::make([
            'ticket_type' => [
                'id' => 'tt_new',
                'name' => 'VIP',
                'type' => 'fiat-price',
                'require_approval' => false,
                'is_hidden' => false,
                'api_id' => 'tt_new',
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $ticketType = $sdk->events()->createTicketType(new CreateTicketTypeRequest(
        eventApiId: 'evt_123',
        name: 'VIP',
        type: 'paid',
    ));

    expect($ticketType)->toBeInstanceOf(TicketTypeResponse::class);
    expect($ticketType->name)->toBe('VIP');
});

it('deletes a ticket type', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        DeleteTicketTypeRequest::class => MockResponse::make([]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $sdk->events()->deleteTicketType('tt_123');

    $mockClient->assertSent(DeleteTicketTypeRequest::class);
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
