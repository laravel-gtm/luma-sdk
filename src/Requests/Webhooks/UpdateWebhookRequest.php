<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Webhooks;

use LaravelGtm\LumaSdk\Enums\WebhookStatus;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateWebhookRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string[]|null  $eventTypes
     */
    public function __construct(
        private readonly string $id,
        private readonly ?array $eventTypes = null,
        private readonly ?WebhookStatus $status = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/webhooks/update';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'id' => $this->id,
            'event_types' => $this->eventTypes,
            'status' => $this->status?->value,
        ], fn (mixed $value): bool => $value !== null);
    }
}
