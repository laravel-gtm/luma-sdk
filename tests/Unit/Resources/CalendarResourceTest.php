<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Calendars\AddCalendarEventRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ApplyEventTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ApplyPersonTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\CreateCalendarCouponRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\CreatePersonTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\GetCalendarRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarEventsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListEventTagsRequest;
use LaravelGtm\LumaSdk\Responses\AddEventResponse;
use LaravelGtm\LumaSdk\Responses\CalendarEventEntry;
use LaravelGtm\LumaSdk\Responses\CalendarResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\TagActionResponse;
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

it('adds a luma event to calendar', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        AddCalendarEventRequest::class => MockResponse::make([
            'api_id' => 'evt_added',
            'status' => 'approved',
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->calendars()->addEvent(
        AddCalendarEventRequest::forLuma('evt_123'),
    );

    expect($response)->toBeInstanceOf(AddEventResponse::class);
    expect($response->apiId)->toBe('evt_added');
    expect($response->status)->toBe('approved');
});

it('creates a person tag and returns api id', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CreatePersonTagRequest::class => MockResponse::make([
            'tag_api_id' => 'tag_new',
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $tagId = $sdk->calendars()->createPersonTag('VIP', 'blue');

    expect($tagId)->toBe('tag_new');
});

it('applies a person tag', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        ApplyPersonTagRequest::class => MockResponse::make([
            'applied_count' => 3,
            'skipped_count' => 1,
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->calendars()->applyPersonTag(
        new ApplyPersonTagRequest('tag_123', emails: ['a@b.test', 'c@d.test']),
    );

    expect($response)->toBeInstanceOf(TagActionResponse::class);
    expect($response->appliedCount)->toBe(3);
    expect($response->skippedCount)->toBe(1);
});

it('applies an event tag', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        ApplyEventTagRequest::class => MockResponse::make([
            'applied_count' => 2,
            'skipped_count' => 0,
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->calendars()->applyEventTag('tag_123', ['evt_1', 'evt_2']);

    expect($response)->toBeInstanceOf(TagActionResponse::class);
    expect($response->appliedCount)->toBe(2);
});

it('creates a calendar coupon', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CreateCalendarCouponRequest::class => MockResponse::make([
            'coupon' => ['api_id' => 'cpn_cal_1'],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $apiId = $sdk->calendars()->createCoupon(new CreateCalendarCouponRequest(
        code: 'CALDISC',
        discount: ['discount_type' => 'percent', 'percent_off' => 15],
    ));

    expect($apiId)->toBe('cpn_cal_1');
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
