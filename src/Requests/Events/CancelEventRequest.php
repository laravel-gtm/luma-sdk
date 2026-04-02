<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CancelEventRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $eventId,
        private readonly string $cancellationToken,
        private readonly ?bool $shouldRefund = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/cancel';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'event_id' => $this->eventId,
            'cancellation_token' => $this->cancellationToken,
            'should_refund' => $this->shouldRefund,
        ], fn (mixed $value): bool => $value !== null);
    }
}
