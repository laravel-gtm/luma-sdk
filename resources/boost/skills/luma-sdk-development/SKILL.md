---
name: luma-sdk-development
description: Build features using the Luma event platform SDK, including events, calendars, guests, webhooks, memberships, and ticketing.
---

# Luma SDK Development

## When to use this skill

Use this skill when working with the `laravel-gtm/luma-sdk` package to interact with the Luma event platform API. This includes creating/managing events, handling guests and RSVPs, setting up webhooks, managing memberships, working with calendars, and ticketing.

## SDK entry point

Inject `LumaSdk` or use the static factory:

```php
use LaravelGtm\LumaSdk\LumaSdk;

// Via Laravel container (recommended)
$luma = app(LumaSdk::class);

// Standalone
$luma = LumaSdk::make(
    baseUrl: 'https://public-api.luma.com',
    token: 'your-api-token',
);
```

## Resources and methods

### Events

```php
// Get event details (returns GetEventResponse with event + hosts)
$event = $luma->events()->get($eventId);
$event->event->name;
$event->hosts; // HostResponse[]

// Create event (returns api_id string)
use LaravelGtm\LumaSdk\Requests\Events\CreateEventRequest;

$apiId = $luma->events()->create(new CreateEventRequest(
    name: 'Laravel Meetup',
    startAt: '2024-12-01T18:00:00.000Z',
    timezone: 'America/New_York',
    endAt: '2024-12-01T21:00:00.000Z',
    descriptionMd: '# Welcome\nJoin us for a Laravel meetup.',
    visibility: 'public',
    maxCapacity: 100,
));

// Update event
use LaravelGtm\LumaSdk\Requests\Events\UpdateEventRequest;

$luma->events()->update(new UpdateEventRequest(
    eventApiId: $apiId,
    name: 'Updated Name',
    suppressNotifications: true,
));

// Cancel event (two-step process)
$token = $luma->events()->requestCancellation($eventId);
$luma->events()->cancel($eventId, $token->cancellationToken, shouldRefund: true);
```

### Guests

```php
use LaravelGtm\LumaSdk\Requests\Events\ListGuestsRequest;
use LaravelGtm\LumaSdk\Requests\Events\AddGuestsRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateGuestStatusRequest;
use LaravelGtm\LumaSdk\Requests\Events\SendInvitesRequest;

// List guests with pagination and filtering
$guests = $luma->events()->listGuests(new ListGuestsRequest(
    eventId: $eventId,
    approvalStatus: 'approved',
    paginationLimit: 50,
));

foreach ($guests->entries as $guest) {
    $guest->userEmail;
    $guest->approvalStatus; // ApprovalStatus enum
    $guest->registeredAt;   // LumaDate value object
    $guest->eventTickets;   // EventTicketResponse[]
}

// Get single guest
$guest = $luma->events()->getGuest(eventId: $eventId, id: $guestId);

// Add guests to event
$luma->events()->addGuests(new AddGuestsRequest(
    eventApiId: $eventId,
    guests: [
        ['email' => 'alice@example.com', 'name' => 'Alice'],
        ['email' => 'bob@example.com', 'name' => 'Bob'],
    ],
));

// Update guest approval status
$luma->events()->updateGuestStatus(new UpdateGuestStatusRequest(
    eventId: $eventId,
    guestId: $guestId,
    status: 'approved',
));

// Send invites
$luma->events()->sendInvites(new SendInvitesRequest(
    eventApiId: $eventId,
    emails: ['alice@example.com', 'bob@example.com'],
));
```

### Hosts

```php
use LaravelGtm\LumaSdk\Requests\Events\CreateHostRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateHostRequest;

// Add a host
$luma->events()->createHost(new CreateHostRequest(
    eventId: $eventId,
    email: 'host@example.com',
    accessLevel: 'manager', // none, check_in, manager
));

// Update host access
$luma->events()->updateHost(new UpdateHostRequest(
    eventId: $eventId,
    email: 'host@example.com',
    accessLevel: 'check_in',
));

// Remove host
$luma->events()->removeHost($eventId, 'host@example.com');
```

### Ticket types

```php
use LaravelGtm\LumaSdk\Requests\Events\CreateTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateTicketTypeRequest;

// List ticket types
$types = $luma->events()->listTicketTypes($eventId, includeHidden: 'true');

// Get single ticket type
$type = $luma->events()->getTicketType($ticketTypeId);

// Create ticket type
$type = $luma->events()->createTicketType(new CreateTicketTypeRequest(
    eventApiId: $eventId,
    name: 'VIP',
    price: 5000, // cents
    currency: 'usd',
    maxCapacity: 50,
));

// Update ticket type
$type = $luma->events()->updateTicketType(new UpdateTicketTypeRequest(
    eventTicketTypeApiId: $type->apiId,
    name: 'VIP - Early Bird',
    price: 3500,
));

// Delete ticket type
$luma->events()->deleteTicketType($ticketTypeApiId);
```

### Coupons (event-level and calendar-level)

```php
use LaravelGtm\LumaSdk\Requests\Events\CreateEventCouponRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateEventCouponRequest;

// Event coupons
$coupons = $luma->events()->listCoupons(new ListEventCouponsRequest(eventId: $eventId));

$couponApiId = $luma->events()->createCoupon(new CreateEventCouponRequest(
    eventApiId: $eventId,
    code: 'EARLYBIRD',
    percentOff: 20.0,
    remainingCount: 100,
));

$luma->events()->updateCoupon(new UpdateEventCouponRequest(
    couponApiId: $couponApiId,
    remainingCount: 50,
));

// Calendar coupons follow the same pattern
use LaravelGtm\LumaSdk\Requests\Calendars\CreateCalendarCouponRequest;

$luma->calendars()->createCoupon(new CreateCalendarCouponRequest(
    code: 'WELCOME',
    percentOff: 10.0,
));
```

### Calendars

```php
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarEventsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\AddCalendarEventRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\LookupEventRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ImportPeopleRequest;

// Get calendar info
$calendar = $luma->calendars()->get();

// List calendar events with date filters
$events = $luma->calendars()->listEvents(new ListCalendarEventsRequest(
    after: '2024-01-01T00:00:00.000Z',
    before: '2024-12-31T23:59:59.000Z',
    paginationLimit: 25,
));

foreach ($events->entries as $entry) {
    $entry->event;  // EventResponse
    $entry->tags;   // TagResponse[]
    $entry->apiId;
}

// Add external event to calendar
$result = $luma->calendars()->addEvent(
    AddCalendarEventRequest::forExternal(url: 'https://example.com/event')
);

// Add Luma event to calendar
$result = $luma->calendars()->addEvent(
    AddCalendarEventRequest::forLuma(eventApiId: $eventApiId)
);

// Lookup event by URL or API ID
$found = $luma->calendars()->lookupEvent(new LookupEventRequest(url: 'https://lu.ma/my-event'));

// List people in calendar
$people = $luma->calendars()->listPeople();
foreach ($people->entries as $person) {
    $person->user->email;
    $person->eventApprovedCount;
    $person->tags; // TagResponse[]
}

// List admins
$admins = $luma->calendars()->listAdmins();

// Import people
$luma->calendars()->importPeople(new ImportPeopleRequest(
    people: [
        ['email' => 'alice@example.com', 'name' => 'Alice'],
    ],
));
```

### Tags (person and event)

```php
// Create tags
$tagApiId = $luma->calendars()->createPersonTag('VIP', '#ff0000');
$tagApiId = $luma->calendars()->createEventTag('Featured', '#00ff00');

// Update tags
$luma->calendars()->updatePersonTag($tagApiId, name: 'Super VIP');

// Apply/remove person tags
use LaravelGtm\LumaSdk\Requests\Calendars\ApplyPersonTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\UnapplyPersonTagRequest;

$result = $luma->calendars()->applyPersonTag(new ApplyPersonTagRequest(
    tag: $tagApiId,
    emails: ['alice@example.com', 'bob@example.com'],
));
// $result->appliedCount, $result->skippedCount

// Apply/remove event tags
$result = $luma->calendars()->applyEventTag($tagApiId, [$eventApiId1, $eventApiId2]);

// Delete tags
$luma->calendars()->deletePersonTag($tagApiId);
$luma->calendars()->deleteEventTag($tagApiId);

// List tags
$personTags = $luma->calendars()->listPersonTags(); // PaginatedResponse<TagResponse>
$eventTags = $luma->calendars()->listEventTags();    // TagResponse[]
```

### Webhooks

```php
use LaravelGtm\LumaSdk\Requests\Webhooks\UpdateWebhookRequest;

// CRUD
$webhook = $luma->webhooks()->create('https://example.com/hook', ['event.created', 'guest.created']);
$webhook = $luma->webhooks()->get($webhookId);
$webhooks = $luma->webhooks()->list();

$luma->webhooks()->update(new UpdateWebhookRequest(
    id: $webhookId,
    status: 'paused', // active, paused
));

$luma->webhooks()->delete($webhookId);

// Webhook response includes the signing secret
$webhook->secret; // Use to verify webhook payloads
```

### Memberships

```php
use LaravelGtm\LumaSdk\Requests\Memberships\AddMemberRequest;

// List tiers
$tiers = $luma->memberships()->listTiers();
foreach ($tiers->entries as $tier) {
    $tier->name;
    $tier->accessInfo->type; // free, payment-once, payment-recurring
}

// Add member
$result = $luma->memberships()->addMember(new AddMemberRequest(
    email: 'member@example.com',
    membershipTierId: $tierId,
    skipPayment: true,
));

// Update member status
$luma->memberships()->updateMemberStatus($userId, 'approved'); // approved, pending, declined
```

### Organizations

```php
$calendars = $luma->organizations()->listCalendars();
```

### Images

```php
$upload = $luma->images()->createUploadUrl('avatar', 'image/png');
$upload->uploadUrl; // PUT your image here
$upload->fileUrl;   // Use this URL in event coverUrl, etc.
```

## Value objects

Always use value objects for Luma-specific formats:

```php
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;
use LaravelGtm\LumaSdk\ValueObjects\GooglePlaceId;

// Dates - always UTC ISO 8601
$date = LumaDate::fromString('2024-06-15T18:00:00.000Z');
$date->toString();                        // '2024-06-15T18:00:00.000Z'
$date->toTimezone('America/New_York');     // DateTimeImmutable in ET

// Durations - ISO 8601 format
$duration = LumaDuration::fromString('PT1H30M');
$duration->toSeconds(); // 5400

// Google Place IDs
$place = GooglePlaceId::fromArray(['place_id' => 'ChIJ...']);
$place->toArray(); // ['place_id' => 'ChIJ...']
```

## Enums

The SDK provides backed enums for API constants:

- `ApprovalStatus` - approved, session, pending_approval, invited, declined, waitlist
- `Visibility` - public, members_only, private
- `WebhookStatus` - active, paused
- `MemberStatus` - approved, pending, approved-pending-payment, declined
- `AccessInfoType` - free, payment-once, payment-recurring
- `HostAccessLevel` - none, check_in, manager
- `TicketPriceType` - free, fiat-price
- `SortDirection` - asc, desc, asc_nulls_last, desc_nulls_last

## Pagination pattern

All list endpoints return `PaginatedResponse` with cursor-based pagination:

```php
$cursor = null;

do {
    $response = $luma->events()->listGuests(new ListGuestsRequest(
        eventId: $eventId,
        paginationLimit: 100,
        paginationCursor: $cursor,
    ));

    foreach ($response->entries as $guest) {
        // Process guest
    }

    $cursor = $response->nextCursor;
} while ($response->hasMore);
```

## Rate limits

The SDK enforces Luma API rate limits automatically via Saloon:

- **GET requests**: 500 per 5 minutes
- **POST requests**: 100 per 5 minutes

In Laravel, rate limit state is stored in the application cache. In standalone mode, it uses an in-memory store.

## Testing with the SDK

Use Saloon's mock system. Never make real API calls in tests:

```php
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Events\GetEventRequest;

it('fetches an event', function () {
    $mockClient = new MockClient([
        GetEventRequest::class => MockResponse::make([
            'event' => [
                'api_id' => 'evt-123',
                'name' => 'Test Event',
                'start_at' => '2024-06-15T18:00:00.000Z',
                'created_at' => '2024-06-01T10:00:00.000Z',
                'url' => 'https://lu.ma/test',
            ],
            'hosts' => [],
        ]),
    ]);

    $luma = app(LumaSdk::class);
    $luma->connector()->withMockClient($mockClient);

    $result = $luma->events()->get('evt-123');

    expect($result->event->name)->toBe('Test Event');
    $mockClient->assertSent(GetEventRequest::class);
});
```

