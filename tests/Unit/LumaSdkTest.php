<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\PingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('returns a normalized ping response from mocked saloon responses', function (): void {
    $connector = new LumaConnector('https://example.test', 'token');
    $connector->withMockClient(new MockClient([
        PingRequest::class => MockResponse::make(['ok' => true], 200),
    ]));

    $sdk = new LumaSdk($connector);
    $response = $sdk->ping();

    expect($response->ok)->toBeTrue();
    expect($response->raw)->toBe(['ok' => true]);
});

it('offers a factory helper for base url and token', function (): void {
    $sdk = LumaSdk::make('https://example.test', 'token');

    expect($sdk)->toBeInstanceOf(LumaSdk::class);
});
