<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Webhooks;

use LaravelGtm\LumaSdk\Responses\WebhookResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Retrieves a webhook by API ID.
 *
 * `GET /v1/webhooks/get`
 */
class GetWebhookRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/webhooks/get';
    }

    protected function defaultQuery(): array
    {
        return ['id' => $this->id];
    }

    public function createDtoFromResponse(Response $response): WebhookResponse
    {
        /** @var array{webhook: array<string, mixed>} $data */
        $data = $response->json();

        return WebhookResponse::fromArray($data['webhook']);
    }
}
