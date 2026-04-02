<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Images\CreateUploadUrlRequest;
use LaravelGtm\LumaSdk\Responses\UploadUrlResponse;
use Saloon\Http\BaseResource;

class ImageResource extends BaseResource
{
    public function createUploadUrl(string $purpose, ?string $contentType = null): UploadUrlResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send(new CreateUploadUrlRequest($purpose, $contentType))->json();

        return UploadUrlResponse::fromArray($data);
    }
}
