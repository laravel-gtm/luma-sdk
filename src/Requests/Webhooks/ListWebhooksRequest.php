<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Webhooks;

use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\WebhookResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Lists webhooks.
 *
 * `GET /v1/webhooks/list`
 */
class ListWebhooksRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/webhooks/list';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'pagination_cursor' => $this->paginationCursor,
            'pagination_limit' => $this->paginationLimit,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<WebhookResponse>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return PaginatedResponse::fromArray($data, WebhookResponse::fromArray(...));
    }
}
