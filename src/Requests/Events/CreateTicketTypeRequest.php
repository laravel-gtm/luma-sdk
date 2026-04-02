<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateTicketTypeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $eventApiId,
        private readonly string $name,
        private readonly string $type,
        private readonly ?bool $requireApproval = null,
        private readonly ?bool $isHidden = null,
        private readonly ?string $description = null,
        private readonly ?LumaDate $validStartAt = null,
        private readonly ?LumaDate $validEndAt = null,
        private readonly ?int $maxCapacity = null,
        private readonly ?int $cents = null,
        private readonly ?string $currency = null,
        private readonly ?bool $isFlexible = null,
        private readonly ?int $minCents = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/ticket-types/create';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'event_api_id' => $this->eventApiId,
            'name' => $this->name,
            'type' => $this->type,
            'require_approval' => $this->requireApproval,
            'is_hidden' => $this->isHidden,
            'description' => $this->description,
            'valid_start_at' => $this->validStartAt?->toString(),
            'valid_end_at' => $this->validEndAt?->toString(),
            'max_capacity' => $this->maxCapacity,
            'cents' => $this->cents,
            'currency' => $this->currency,
            'is_flexible' => $this->isFlexible,
            'min_cents' => $this->minCents,
        ], fn (mixed $value): bool => $value !== null);
    }
}
