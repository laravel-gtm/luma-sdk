<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateGuestStatusRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array{type: string, email?: string, api_id?: string}  $guest
     */
    public function __construct(
        private readonly array $guest,
        private readonly string $eventApiId,
        private readonly string $status,
        private readonly ?bool $shouldRefund = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/update-guest-status';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'guest' => $this->guest,
            'event_api_id' => $this->eventApiId,
            'status' => $this->status,
            'should_refund' => $this->shouldRefund,
        ], fn (mixed $value): bool => $value !== null);
    }
}
