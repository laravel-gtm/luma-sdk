<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Removes a host from an event.
 *
 * `POST /v1/event/hosts/remove`
 */
class RemoveHostRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $eventId,
        private readonly string $email,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/hosts/remove';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'event_id' => $this->eventId,
            'email' => $this->email,
        ];
    }
}
