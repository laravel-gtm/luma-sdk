<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Webhooks\GetWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\ListWebhooksRequest;
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
}
