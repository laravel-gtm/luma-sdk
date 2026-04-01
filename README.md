# Luma SDK

[![Tests](https://github.com/laravel-gtm/luma-sdk/actions/workflows/tests.yml/badge.svg)](https://github.com/laravel-gtm/luma-sdk/actions/workflows/tests.yml)

Laravel-ready PHP SDK for Luma REST APIs built with Saloon.

## Requirements

- PHP `^8.4`
- Laravel `^11.0 || ^12.0` (for service provider + config integration)

## Installation

```bash
composer require laravel-gtm/luma-sdk
```

## Laravel Setup

The package supports Laravel auto-discovery for `LumaServiceProvider`.

Publish configuration:

```bash
php artisan vendor:publish --tag=luma-config
```

Set your environment variables:

```dotenv
LUMA_BASE_URL=https://api.luma.ai
LUMA_API_TOKEN=your-token
```

## Usage

Resolve the SDK from the service container and call methods:

```php
use LaravelGtm\LumaSdk\LumaSdk;

$sdk = app(LumaSdk::class);
$ping = $sdk->ping();

if ($ping->ok) {
    // API is reachable
}
```

You can also build an instance directly:

```php
use LaravelGtm\LumaSdk\LumaSdk;

$sdk = LumaSdk::make(
    baseUrl: 'https://api.luma.ai',
    token: 'your-token',
);
```

## Testing

Run the package test suite:

```bash
composer test
```

Run all quality checks:

```bash
composer test
composer lint
composer analyse
```
