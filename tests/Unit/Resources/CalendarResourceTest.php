<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Calendars\GetCalendarRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarEventsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListEventTagsRequest;
use LaravelGtm\LumaSdk\Responses\CalendarEventEntry;
use LaravelGtm\LumaSdk\Responses\CalendarResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\TagResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

beforeEach(function (): void {
    $refl = new ReflectionProperty(MemoryStore::class, 'store');
    $refl->setValue(null, []);
});

it('gets calendar details', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        GetCalendarRequest::class => MockResponse::make([
            'calendar' => [
                'id' => 'cal_123',
                'name' => 'Test Calendar',
                'slug' => 'test-cal',
                'is_personal' => true,
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->calendars()->get();

    expect($response)->toBeInstanceOf(CalendarResponse::class);
    expect($response->name)->toBe('Test Calendar');
    expect($response->isPersonal)->toBeTrue();

    $mockClient->assertSent(GetCalendarRequest::class);
});

it('lists calendar events with pagination', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        ListCalendarEventsRequest::class => MockResponse::make([
            'entries' => [
                [
                    'api_id' => 'entry_1',
                    'event' => [
                        'id' => 'evt_1',
                        'name' => 'Event One',
                        'start_at' => '2024-06-15T18:00:00.000Z',
                        'created_at' => '2024-06-01T10:00:00.000Z',
                        'url' => 'https://lu.ma/event-one',
                    ],
                    'tags' => [
                        ['api_id' => 'tag_1', 'name' => 'Featured'],
                    ],
                ],
            ],
            'has_more' => true,
            'next_cursor' => 'cursor_next',
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->calendars()->listEvents();

    expect($response)->toBeInstanceOf(PaginatedResponse::class);
    expect($response->entries)->toHaveCount(1);
    expect($response->entries[0])->toBeInstanceOf(CalendarEventEntry::class);
    expect($response->entries[0]->event->name)->toBe('Event One');
    expect($response->hasMore)->toBeTrue();
    expect($response->nextCursor)->toBe('cursor_next');

    $mockClient->assertSent(ListCalendarEventsRequest::class);
});

it('lists event tags', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        ListEventTagsRequest::class => MockResponse::make([
            'entries' => [
                ['api_id' => 'tag_1', 'name' => 'Workshop', 'color' => '#blue'],
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $tags = $sdk->calendars()->listEventTags();

    expect($tags)->toHaveCount(1);
    expect($tags[0])->toBeInstanceOf(TagResponse::class);
    expect($tags[0]->name)->toBe('Workshop');

    $mockClient->assertSent(ListEventTagsRequest::class);
});
