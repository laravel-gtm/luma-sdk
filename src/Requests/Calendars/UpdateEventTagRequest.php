<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateEventTagRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $tagApiId,
        private readonly ?string $name = null,
        private readonly ?string $color = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/event-tags/update';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter([
            'tag_api_id' => $this->tagApiId,
            'name' => $this->name,
            'color' => $this->color,
        ], fn (mixed $value): bool => $value !== null);
    }
}
