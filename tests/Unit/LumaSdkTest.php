<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\GetSelfRequest;
use LaravelGtm\LumaSdk\Responses\UserResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('returns a user response from get self endpoint', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token');
    $mockClient = new MockClient([
        GetSelfRequest::class => MockResponse::make([
            'user' => [
                'id' => 'usr_123',
                'name' => 'Jane Doe',
                'avatar_url' => 'https://example.test/avatar.jpg',
                'email' => 'jane@example.test',
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'api_id' => 'usr_123',
            ],
        ], 200),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->getSelf();

    expect($response)->toBeInstanceOf(UserResponse::class);
    expect($response->id)->toBe('usr_123');
    expect($response->name)->toBe('Jane Doe');
    expect($response->avatarUrl)->toBe('https://example.test/avatar.jpg');
    expect($response->email)->toBe('jane@example.test');
    expect($response->firstName)->toBe('Jane');
    expect($response->lastName)->toBe('Doe');

    $mockClient->assertSent(GetSelfRequest::class);
});

it('handles nullable name fields', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token');
    $mockClient = new MockClient([
        GetSelfRequest::class => MockResponse::make([
            'user' => [
                'id' => 'usr_456',
                'name' => null,
                'avatar_url' => 'https://example.test/avatar.jpg',
                'email' => 'anon@example.test',
                'first_name' => null,
                'last_name' => null,
                'api_id' => 'usr_456',
            ],
        ], 200),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->getSelf();

    expect($response->name)->toBeNull();
    expect($response->firstName)->toBeNull();
    expect($response->lastName)->toBeNull();

    $mockClient->assertSent(GetSelfRequest::class);
});

it('offers a factory helper for base url and token', function (): void {
    $sdk = LumaSdk::make('https://example.test', 'test-token');

    expect($sdk)->toBeInstanceOf(LumaSdk::class);
});
