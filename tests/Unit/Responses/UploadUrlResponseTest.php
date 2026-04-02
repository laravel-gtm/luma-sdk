<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Responses\UploadUrlResponse;

it('creates from array', function (): void {
    $response = UploadUrlResponse::fromArray([
        'upload_url' => 'https://upload.example.test/presigned',
        'file_url' => 'https://images.lumacdn.com/uploaded.jpg',
    ]);

    expect($response->uploadUrl)->toBe('https://upload.example.test/presigned');
    expect($response->fileUrl)->toBe('https://images.lumacdn.com/uploaded.jpg');
});
