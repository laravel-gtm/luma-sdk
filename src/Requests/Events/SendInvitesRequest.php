<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Events;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class SendInvitesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<array{email: string, name?: string|null}>  $guests
     */
    public function __construct(
        private readonly string $eventApiId,
        private readonly array $guests,
        private readonly ?string $message = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/event/send-invites';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'event_api_id' => $this->eventApiId,
            'guests' => $this->guests,
            'message' => $this->message,
        ], fn (mixed $value): bool => $value !== null);
    }
}
