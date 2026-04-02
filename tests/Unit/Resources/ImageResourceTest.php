<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use LaravelGtm\LumaSdk\Requests\Images\CreateUploadUrlRequest;
use LaravelGtm\LumaSdk\Responses\UploadUrlResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\RateLimitPlugin\Stores\MemoryStore;

beforeEach(function (): void {
    $refl = new ReflectionProperty(MemoryStore::class, 'store');
    $refl->setValue(null, []);
});

it('creates an upload url', function (): void {
    $connector = new LumaConnector('https://example.test', 'test-token', new MemoryStore);
    $mockClient = new MockClient([
        CreateUploadUrlRequest::class => MockResponse::make([
            'upload_url' => 'https://upload.example.test/presigned',
            'file_url' => 'https://images.lumacdn.com/uploaded.jpg',
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $sdk = new LumaSdk($connector);
    $response = $sdk->images()->createUploadUrl('event-cover', 'image/jpeg');

    expect($response)->toBeInstanceOf(UploadUrlResponse::class);
    expect($response->uploadUrl)->toBe('https://upload.example.test/presigned');
    expect($response->fileUrl)->toBe('https://images.lumacdn.com/uploaded.jpg');

    $mockClient->assertSent(CreateUploadUrlRequest::class);
});
