<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class DeleteEventTagRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $tagApiId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/event-tags/delete';
    }

    protected function defaultBody(): array
    {
        return [
            'tag_api_id' => $this->tagApiId,
        ];
    }
}
