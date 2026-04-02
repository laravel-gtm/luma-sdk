<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Applies a person tag to people.
 *
 * `POST /v1/calendar/person-tags/apply`
 */
class ApplyPersonTagRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string[]|null  $userApiIds
     * @param  string[]|null  $emails
     */
    public function __construct(
        private readonly string $tag,
        private readonly ?array $userApiIds = null,
        private readonly ?array $emails = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/person-tags/apply';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'tag' => $this->tag,
            'user_api_ids' => $this->userApiIds,
            'emails' => $this->emails,
        ], fn (mixed $value): bool => $value !== null);
    }
}
