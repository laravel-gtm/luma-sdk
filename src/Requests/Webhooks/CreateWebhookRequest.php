<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a webhook.
 *
 * `POST /v1/webhooks/create`
 */
class CreateWebhookRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string[]  $eventTypes
     */
    public function __construct(
        private readonly string $url,
        private readonly array $eventTypes,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/webhooks/create';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'url' => $this->url,
            'event_types' => $this->eventTypes,
        ];
    }
}
