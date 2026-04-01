<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use Saloon\Http\Auth\TokenAuthenticator;

it('resolves custom base urls without trailing slash', function (): void {
    $connector = new LumaConnector('https://example.test/', null);

    expect($connector->resolveBaseUrl())->toBe('https://example.test');
});

it('defaults to luma api host when no base url is set', function (): void {
    $connector = new LumaConnector;

    expect($connector->resolveBaseUrl())->toBe('https://api.luma.ai');
});

it('returns null default auth when token is missing', function (): void {
    $connector = new LumaConnector(null, null);
    $method = new ReflectionMethod(LumaConnector::class, 'defaultAuth');

    expect($method->invoke($connector))->toBeNull();
});

it('builds token auth when token is provided', function (): void {
    $connector = new LumaConnector(null, 'test-token');
    $method = new ReflectionMethod(LumaConnector::class, 'defaultAuth');

    expect($method->invoke($connector))->toBeInstanceOf(TokenAuthenticator::class);
});
