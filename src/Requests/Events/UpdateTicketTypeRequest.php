<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateTicketTypeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $eventTicketTypeApiId,
        private readonly ?string $name = null,
        private readonly ?string $type = null,
        private readonly ?bool $requireApproval = null,
        private readonly ?bool $isHidden = null,
        private readonly ?string $description = null,
        private readonly ?string $validStartAt = null,
        private readonly ?string $validEndAt = null,
        private readonly ?int $maxCapacity = null,
        private readonly ?int $cents = null,
        private readonly ?string $currency = null,
        private readonly ?bool $isFlexible = null,
        private readonly ?int $minCents = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/ticket-types/update';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'event_ticket_type_api_id' => $this->eventTicketTypeApiId,
            'name' => $this->name,
            'type' => $this->type,
            'require_approval' => $this->requireApproval,
            'is_hidden' => $this->isHidden,
            'description' => $this->description,
            'valid_start_at' => $this->validStartAt,
            'valid_end_at' => $this->validEndAt,
            'max_capacity' => $this->maxCapacity,
            'cents' => $this->cents,
            'currency' => $this->currency,
            'is_flexible' => $this->isFlexible,
            'min_cents' => $this->minCents,
        ], fn (mixed $value): bool => $value !== null);
    }
}
