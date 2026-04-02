# Luma SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-gtm/luma-sdk.svg?style=flat-square)](https://packagist.org/packages/laravel-gtm/luma-sdk)
[![Tests](https://github.com/laravel-gtm/luma-sdk/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/laravel-gtm/luma-sdk/actions/workflows/tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-gtm/luma-sdk.svg?style=flat-square)](https://packagist.org/packages/laravel-gtm/luma-sdk)
[![PHP Version](https://img.shields.io/packagist/php-v/laravel-gtm/luma-sdk.svg?style=flat-square)](https://packagist.org/packages/laravel-gtm/luma-sdk)
[![License](https://img.shields.io/packagist/l/laravel-gtm/luma-sdk.svg?style=flat-square)](https://packagist.org/packages/laravel-gtm/luma-sdk)

Laravel-ready PHP SDK for the [Luma](https://lu.ma) REST API, built with [Saloon](https://docs.saloon.dev).

## Requirements

- PHP `^8.4`
- Laravel `^11.0 || ^12.0 || ^13.0`

## Installation

```bash
composer require laravel-gtm/luma-sdk
```

The package supports Laravel auto-discovery — no manual provider registration needed.

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=luma-config
```

Set your environment variables:

```dotenv
LUMA_BASE_URL=https://public-api.luma.com
LUMA_API_TOKEN=your-token
```

## Usage

### Via the Service Container (recommended)

```php
use LaravelGtm\LumaSdk\LumaSdk;

$sdk = app(LumaSdk::class);
```

### Standalone

```php
use LaravelGtm\LumaSdk\LumaSdk;

$sdk = LumaSdk::make(
    baseUrl: 'https://public-api.luma.com',
    token: 'your-token',
);
```

### Core Methods

```php
$user = $sdk->getSelf();           // Get authenticated user
$entity = $sdk->lookupEntity($slug); // Look up entity by slug
```

## Resources

The SDK organizes endpoints into resource classes accessed via the main `LumaSdk` instance.

### Events

```php
$events = $sdk->events();

// Read
$event = $events->get($eventId);
$guests = $events->listGuests($request);
$coupons = $events->listCoupons($request);
$ticketTypes = $events->listTicketTypes($eventId);
$ticketType = $events->getTicketType($id);
$guest = $events->getGuest(eventId: $eventId, id: $guestId);

// Create & Update
$events->create($request);
$events->update($request);

// Guests
$events->addGuests($request);
$events->updateGuestStatus($request);
$events->sendInvites($request);

// Hosts
$events->createHost($request);
$events->updateHost($request);
$events->removeHost($eventId, $email);

// Coupons
$events->createCoupon($request);
$events->updateCoupon($request);

// Ticket Types
$events->createTicketType($request);
$events->updateTicketType($request);
$events->deleteTicketType($ticketTypeId);

// Cancellation
$token = $events->requestCancellation($eventId);
$events->cancel($eventId, $token->cancellationToken);
```

### Calendars

```php
$calendars = $sdk->calendars();

// Read
$calendar = $calendars->get();
$events = $calendars->listEvents();
$people = $calendars->listPeople();
$coupons = $calendars->listCoupons();
$admins = $calendars->listAdmins();
$event = $calendars->lookupEvent($request);

// Events
$calendars->addEvent($request);

// Coupons
$calendars->createCoupon($request);
$calendars->updateCoupon($request);

// People
$calendars->importPeople($request);

// Person Tags
$calendars->listPersonTags();
$calendars->createPersonTag('VIP', '#ff0000');
$calendars->updatePersonTag($tagId, name: 'Speaker');
$calendars->deletePersonTag($tagId);
$calendars->applyPersonTag($request);
$calendars->unapplyPersonTag($request);

// Event Tags
$calendars->listEventTags();
$calendars->createEventTag('Workshop');
$calendars->updateEventTag($tagId, name: 'Keynote');
$calendars->deleteEventTag($tagId);
$calendars->applyEventTag($tag, $eventApiIds);
$calendars->unapplyEventTag($tag, $eventApiIds);
```

### Memberships

```php
$memberships = $sdk->memberships();

$tiers = $memberships->listTiers();
$memberships->addMember($request);
$memberships->updateMemberStatus($userId, 'active');
```

### Webhooks

```php
$webhooks = $sdk->webhooks();

$list = $webhooks->list();
$webhook = $webhooks->get($id);
$webhook = $webhooks->create('https://example.com/hook', ['event.created']);
$webhook = $webhooks->update($request);
$webhooks->delete($id);
```

### Organizations

```php
$org = $sdk->organizations();

$calendars = $org->listCalendars();
```

### Images

```php
$images = $sdk->images();

$upload = $images->createUploadUrl('event-cover');
```

## Value Objects

The SDK provides type-safe value objects for Luma-specific formats:

### LumaDate

```php
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

$date = LumaDate::fromString('2026-10-04T05:20:00.000Z');
$date->toString();        // ISO 8601 UTC string
$date->toTimezone('America/New_York'); // Display conversion
```

### LumaDuration

```php
use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;

$duration = LumaDuration::fromString('P1DT12H30M');
$duration->toString();    // ISO 8601 duration string
$duration->toSeconds();   // Numeric representation
```

### GooglePlaceId

```php
use LaravelGtm\LumaSdk\ValueObjects\GooglePlaceId;

$place = GooglePlaceId::fromArray(['place_id' => 'ChIJN1t_tDeuEmsRUsoyG83frY4']);
$place->toArray();        // ['place_id' => '...']
```

## Pagination

Paginated endpoints return a `PaginatedResponse` with cursor-based pagination:

```php
$page = $sdk->events()->listGuests($request);

$page->entries;    // array of response DTOs
$page->hasMore;    // bool
$page->nextCursor; // string|null
```

## Rate Limiting

The SDK includes built-in rate limiting via Saloon's rate-limit plugin:

- **GET requests**: 500 per 5 minutes
- **POST requests**: 100 per 5 minutes

Rate limits are handled automatically — requests will wait when limits are reached.

## Testing

```bash
composer test        # Run test suite
composer lint        # Check code style
composer analyse     # Static analysis (PHPStan)
composer format      # Fix code style
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for recent changes.

## License

The MIT License (MIT). See [LICENSE](LICENSE) for details.
