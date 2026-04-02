<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use LaravelGtm\LumaSdk\Enums\HostAccessLevel;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateHostRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $eventId,
        private readonly string $email,
        private readonly ?HostAccessLevel $accessLevel = null,
        private readonly ?bool $isVisible = null,
        private readonly ?string $name = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/hosts/create';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'event_id' => $this->eventId,
            'email' => $this->email,
            'access_level' => $this->accessLevel?->value,
            'is_visible' => $this->isVisible,
            'name' => $this->name,
        ], fn (mixed $value): bool => $value !== null);
    }
}
