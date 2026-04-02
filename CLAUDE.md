# Project Instructions

This file provides guidance to Agents when working with code in this repository.

## Commands

```bash
composer test                              # Run full test suite (Pest)
composer test -- tests/Unit/SomeTest.php   # Run a single test file
composer lint                              # Check code style (Pint, no changes)
composer format                            # Fix code style (Pint)
composer analyse                           # Static analysis (PHPStan level 5)
```

## Architecture

This is a **Laravel package** providing a PHP SDK for the Luma REST API, built on **Saloon 4.0**.

### Saloon HTTP Client Pattern

```
LumaSdk (facade) → LumaConnector (HTTP client) → Request classes → Response DTOs
```

- **`LumaConnector`** — Saloon `Connector` subclass. Handles base URL, token auth via `TokenAuthenticator`. Configured from `config/luma.php`.
- **`LumaSdk`** — Public API surface. Accepts a connector, exposes SDK methods (e.g., `ping()`). Has a static `make()` factory for standalone use.
- **`src/Requests/`** — One class per API endpoint, extending Saloon's `Request`. Defines HTTP method and endpoint path.
- **`src/Responses/`** — DTOs with `fromArray()` factory methods. Immutable value objects.
- **`src/Laravel/LumaServiceProvider`** — Registers `LumaConnector` and `LumaSdk` as singletons. Publishes config with tag `luma-config`.

### Adding a New Endpoint

1. Create a `Request` class in `src/Requests/` extending `Saloon\Http\Request`
2. Create a `Response` DTO in `src/Responses/` with `fromArray()` factory
3. Add a public method on `LumaSdk` that sends the request and returns the DTO
4. Test with Saloon's `MockClient` and `MockResponse`

### API Route Conventions

Luma uses per-route versioning and currently has a mix of legacy and newer route patterns.

- Treat version as endpoint-specific (`/v1/...` and `/v2/...` can coexist in the SDK)
- Do not assume a global API version
- Do not "normalize" working legacy paths to a newer REST pattern unless explicitly requested
- Prefer exact API-documented paths over inferred naming conventions

#### Expected Pattern (for new and updated endpoints)

`/v{version}/{resource}/{action}`

Examples:
- `GET /v1/event/ticket-types/list`
- `GET /v1/event/ticket-types/get`
- `POST /v1/event/ticket-types/create`
- `POST /v1/event/ticket-types/update`
- `POST /v1/event/ticket-types/delete`

#### Method Rules

- Read actions (`list`, `get`) use `GET`
- Write actions (`create`, `update`, `delete`) use `POST`
- If docs and convention conflict, follow docs for that endpoint

#### SDK Request Implementation Rules

When adding or changing a request class:
1. Set the exact endpoint string (including version) in `resolveEndpoint()`
2. Set HTTP method explicitly on the request class
3. Preserve exact resource/action formatting from docs (including hyphenation/pluralization)
4. Add or update tests that verify method, endpoint, and query/body mapping

### API Format Value Objects

The Luma API uses specific formats for dates, durations, and locations. These are represented as value objects in `src/ValueObjects/`:

- **`LumaDate`** — ISO 8601 dates (`2022-10-04T05:20:00.000Z`). All times are UTC. Use `LumaDate::fromString()` when parsing API responses and `->toString()` when building request payloads. Use `->toTimezone()` for display conversion.
- **`LumaDuration`** — ISO 8601 durations (`P1DT12H30M`). Use `LumaDuration::fromString()` to parse and `->toString()` to serialize. `->toSeconds()` gives a numeric representation.
- **`GooglePlaceId`** — Google Maps Place IDs for event locations. Use `GooglePlaceId::fromArray()` when the API returns `{"place_id": "..."}` and `->toArray()` when sending locations.

**Rules for Response DTOs:**
- Date/time fields from the API → `LumaDate` (never raw strings or `Carbon`)
- Duration fields from the API → `LumaDuration` (never raw strings)
- Location fields with `place_id` → `GooglePlaceId` (never raw strings)
- DTOs expose the value objects directly; consumers handle timezone conversion

## Conventions

- PHP 8.4+, `declare(strict_types=1)` in all files
- `readonly` properties for immutability
- Full type declarations on all methods and properties
- Tests use Pest's `it()` syntax with `expect()` assertions
- Saloon `MockClient`/`MockResponse` for HTTP mocking in tests
- Require `illuminate/*` packages, never `laravel/framework`
