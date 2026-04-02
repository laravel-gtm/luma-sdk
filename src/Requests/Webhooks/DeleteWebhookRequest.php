<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Deletes a webhook by API ID.
 *
 * `POST /v1/webhooks/delete`
 */
class DeleteWebhookRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/webhooks/delete';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
