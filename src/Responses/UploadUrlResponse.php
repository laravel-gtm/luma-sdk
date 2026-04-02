<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Responses;

class UploadUrlResponse
{
    public function __construct(
        public readonly string $uploadUrl,
        public readonly string $fileUrl,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            uploadUrl: (string) $data['upload_url'],
            fileUrl: (string) $data['file_url'],
        );
    }
}
