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
     * Lists webhooks with pagination.
     *
     * @return PaginatedResponse<WebhookResponse>
     *
     * @see ListWebhooksRequest
     */
    public function list(ListWebhooksRequest $request = new ListWebhooksRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<WebhookResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * Gets a webhook by API id.
     *
     * @see GetWebhookRequest
     */
    public function get(string $id): WebhookResponse
    {
        /** @var WebhookResponse */
        return $this->connector->send(new GetWebhookRequest($id))->dtoOrFail();
    }

    /**
     * Creates a webhook.
     *
     * @param  string[]  $eventTypes
     *
     * @see CreateWebhookRequest
     */
    public function create(string $url, array $eventTypes): WebhookResponse
    {
        /** @var array{webhook: array<string, mixed>} $data */
        $data = $this->connector->send(new CreateWebhookRequest($url, $eventTypes))->json();

        return WebhookResponse::fromArray($data['webhook']);
    }

    /**
     * Updates an existing webhook.
     *
     * @see UpdateWebhookRequest
     */
    public function update(UpdateWebhookRequest $request): WebhookResponse
    {
        /** @var array{webhook: array<string, mixed>} $data */
        $data = $this->connector->send($request)->json();

        return WebhookResponse::fromArray($data['webhook']);
    }

    /**
     * Deletes a webhook by API id.
     *
     * @see DeleteWebhookRequest
     */
    public function delete(string $id): void
    {
        $this->connector->send(new DeleteWebhookRequest($id));
    }
}
