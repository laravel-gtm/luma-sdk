<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Images;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates an image upload URL.
 *
 * `POST /v1/images/create-upload-url`
 */
class CreateUploadUrlRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $purpose,
        private readonly ?string $contentType = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/images/create-upload-url';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'purpose' => $this->purpose,
            'content_type' => $this->contentType,
        ], fn (mixed $value): bool => $value !== null);
    }
}
