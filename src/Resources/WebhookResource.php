<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Webhooks\CreateWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\DeleteWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\GetWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\ListWebhooksRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\UpdateWebhookRequest;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\WebhookResponse;
use Saloon\Http\BaseResource;

class WebhookResource extends BaseResource
{
    /**
     * @return PaginatedResponse<WebhookResponse>
     */
    public function list(ListWebhooksRequest $request = new ListWebhooksRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<WebhookResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    public function get(string $id): WebhookResponse
    {
        /** @var WebhookResponse */
        return $this->connector->send(new GetWebhookRequest($id))->dtoOrFail();
    }

    /**
     * @param  string[]  $eventTypes
     */
    public function create(string $url, array $eventTypes): WebhookResponse
    {
        /** @var array{webhook: array<string, mixed>} $data */
        $data = $this->connector->send(new CreateWebhookRequest($url, $eventTypes))->json();

        return WebhookResponse::fromArray($data['webhook']);
    }

    public function update(UpdateWebhookRequest $request): WebhookResponse
    {
        /** @var array{webhook: array<string, mixed>} $data */
        $data = $this->connector->send($request)->json();

        return WebhookResponse::fromArray($data['webhook']);
    }

    public function delete(string $id): void
    {
        $this->connector->send(new DeleteWebhookRequest($id));
    }
}
