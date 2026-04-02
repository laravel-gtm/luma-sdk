## Luma SDK (`laravel-gtm/luma-sdk`)

This package provides a PHP SDK for the [Luma](https://lu.ma) REST API, built on Saloon 4.0. It wraps all Luma public API endpoints with typed request classes, response DTOs, and value objects.

### Setup

Add your API token to `.env`:

```
LUMA_API_TOKEN=your-token-here
```

Publish the config file if you need to customize the base URL:

```bash
php artisan vendor:publish --tag=luma-config
```

### Usage

- **`LumaSdk`** is the main entry point. Inject it via the Laravel container or use `LumaSdk::make()` for standalone use.
- Call resource methods to access API endpoints: `events()`, `calendars()`, `webhooks()`, `memberships()`, `organizations()`, `images()`.
- Build request objects with named constructor parameters and pass them to resource methods.
- Responses are immutable DTOs with typed properties — access data directly via properties.

### Resource Methods

Access resources through `LumaSdk`:

@verbatim
<code-snippet name="Accessing SDK resources" lang="php">
use LaravelGtm\LumaSdk\LumaSdk;

$luma = app(LumaSdk::class);

// Top-level methods
$user = $luma->getSelf();
$entity = $luma->lookupEntity('my-calendar-slug');

// Resource groups
$luma->events()->get($eventId);
$luma->calendars()->listEvents();
$luma->webhooks()->list();
$luma->memberships()->listTiers();
$luma->organizations()->listCalendars();
$luma->images()->createUploadUrl('avatar');
</code-snippet>
@endverbatim

### Value Objects

The SDK uses value objects for Luma-specific formats. Always use these instead of raw strings:

- **`LumaDate`** for ISO 8601 dates (`2024-06-15T18:00:00.000Z`). Use `LumaDate::fromString()` to parse, `->toString()` to serialize, `->toTimezone()` for display.
- **`LumaDuration`** for ISO 8601 durations (`PT1H`, `P1DT12H30M`). Use `LumaDuration::fromString()` to parse, `->toSeconds()` for numeric values.
- **`GooglePlaceId`** for location place IDs. Use `GooglePlaceId::fromArray()` to parse, `->toArray()` when sending.

### Request Pattern

Write actions use POST. Read actions use GET. Pass parameters via constructor:

@verbatim
<code-snippet name="Creating a request" lang="php">
use LaravelGtm\LumaSdk\Requests\Events\CreateEventRequest;

$request = new CreateEventRequest(
    name: 'My Event',
    startAt: '2024-12-01T18:00:00.000Z',
    timezone: 'America/New_York',
);

$apiId = $luma->events()->create($request);
</code-snippet>
@endverbatim

### Pagination

List endpoints return `PaginatedResponse` with `entries`, `hasMore`, and `nextCursor`:

@verbatim
<code-snippet name="Paginating results" lang="php">
use LaravelGtm\LumaSdk\Requests\Events\ListGuestsRequest;

$response = $luma->events()->listGuests(new ListGuestsRequest(
    eventId: $eventId,
    paginationLimit: 50,
));

foreach ($response->entries as $guest) {
    // $guest is a GuestResponse
}

if ($response->hasMore) {
    // Pass $response->nextCursor to the next request
}
</code-snippet>
@endverbatim

### Testing

Use Saloon's `MockClient` and `MockResponse` for testing. Never make real API calls in tests:

@verbatim
<code-snippet name="Mocking Luma API calls" lang="php">
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use LaravelGtm\LumaSdk\Requests\Events\GetEventRequest;

$mockClient = new MockClient([
    GetEventRequest::class => MockResponse::make(['event' => [...]]),
]);

$connector->withMockClient($mockClient);
</code-snippet>
@endverbatim

### Important Notes

- Rate limits are enforced automatically: 500 GETs and 100 POSTs per 5 minutes. In Laravel, rate limit state is stored in the application cache.
- When testing code that uses the SDK, mock with Saloon's `MockClient` — never make real API calls in tests.
- All date/time properties on response DTOs are `LumaDate` value objects, not raw strings. Use `->toTimezone()` to convert for display.
- All list endpoints use cursor-based pagination. Check `$response->hasMore` and pass `$response->nextCursor` for subsequent pages.
