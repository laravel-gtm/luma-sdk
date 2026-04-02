<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\Requests\PingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

it('defines get and post rate limits', function (): void {
    $connector = new LumaConnector;
    $method = new ReflectionMethod(LumaConnector::class, 'resolveLimits');

    $limits = $method->invoke($connector);

    expect($limits)->toBeArray()->toHaveCount(2);
});

it('uses a memory store by default', function (): void {
    $connector = new LumaConnector;
    $method = new ReflectionMethod(LumaConnector::class, 'resolveRateLimitStore');

    expect($method->invoke($connector))->toBeInstanceOf(MemoryStore::class);
});

it('accepts a custom rate limit store', function (): void {
    $store = new MemoryStore;
    $connector = new LumaConnector(rateLimitStore: $store);
    $method = new ReflectionMethod(LumaConnector::class, 'resolveRateLimitStore');

    expect($method->invoke($connector))->toBe($store);
});

it('throws rate limit exception on 429 response', function (): void {
    $connector = new LumaConnector;

    MockClient::global([
        PingRequest::class => MockResponse::make(body: 'Too Many Requests', status: 429),
    ]);

    $connector->send(new PingRequest);
})->throws(RateLimitReachedException::class);
