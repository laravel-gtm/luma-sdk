<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Memberships\AddMemberRequest;
use LaravelGtm\LumaSdk\Requests\Memberships\UpdateMemberStatusRequest;
use LaravelGtm\LumaSdk\Responses\AddMemberResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

beforeEach(function (): void {
    $refl = new ReflectionProperty(MemoryStore::class, 'store');
    $refl->setValue(null, []);
});

it('adds a member to a tier', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        AddMemberRequest::class => MockResponse::make([
            'membership_id' => 'mem_123',
            'status' => 'approved',
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->memberships()->addMember(new AddMemberRequest(
        email: 'member@example.test',
        membershipTierId: 'tier_123',
        skipPayment: true,
    ));

    expect($response)->toBeInstanceOf(AddMemberResponse::class);
    expect($response->membershipId)->toBe('mem_123');
    expect($response->status)->toBe('approved');

    $mockClient->assertSent(AddMemberRequest::class);
});

it('updates a member status', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        UpdateMemberStatusRequest::class => MockResponse::make([]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $sdk->memberships()->updateMemberStatus('usr_123', 'approved');

    $mockClient->assertSent(UpdateMemberStatusRequest::class);
});
