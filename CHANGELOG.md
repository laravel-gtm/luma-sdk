# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1.2] - 2026-04-02

### Added
- Laravel Boost guidelines and skills for AI-assisted SDK usage in Laravel applications

## [0.1.1] - 2026-04-01

### Added
- GitHub Actions release workflow for automated releases on tag push
- Comprehensive README with full resource documentation, value objects, pagination, and rate limiting

## [0.1.0] - 2026-04-01

### Added
- Full Luma API SDK with all 55 endpoints (20 GET, 35 POST) matching the OpenAPI spec
- Event endpoints: create, update, cancel, manage guests, hosts, coupons, ticket types, and invites
- Calendar endpoints: add events, manage coupons, import people, manage person/event tags
- Webhook endpoints: create, update, and delete webhooks
- Membership endpoints: add members and update member status
- Image endpoint: create presigned upload URLs
- Rate limiting via Saloon rate-limit-plugin (500 req/5min GET, 100 req/5min POST)
- Value objects for type-safe dates (`LumaDate`), durations (`LumaDuration`), and locations (`GooglePlaceId`)
- Paginated response support with cursor-based pagination

## [0.0.1] - 2026-04-01

### Added
- Initial release
- Laravel 13 support
- Orchestra Testbench test infrastructure
- Pint auto-fix CI workflow

[Unreleased]: https://github.com/laravel-gtm/luma-sdk/compare/v0.1.2...HEAD
[0.1.2]: https://github.com/laravel-gtm/luma-sdk/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/laravel-gtm/luma-sdk/compare/v0.1.0...v0.1.1
[0.1.0]: https://github.com/laravel-gtm/luma-sdk/compare/v0.0.1...v0.1.0
[0.0.1]: https://github.com/laravel-gtm/luma-sdk/releases/tag/v0.0.1
