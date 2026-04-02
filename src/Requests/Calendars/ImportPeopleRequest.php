<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Calendars;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class ImportPeopleRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<array{email: string, name?: string|null}>  $infos
     * @param  string[]|null  $tagApiIds
     * @param  string[]|null  $tagNames
     */
    public function __construct(
        private readonly array $infos,
        private readonly ?array $tagApiIds = null,
        private readonly ?array $tagNames = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/calendar/import-people';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'infos' => $this->infos,
            'tag_api_ids' => $this->tagApiIds,
            'tag_names' => $this->tagNames,
        ], fn (mixed $value): bool => $value !== null);
    }
}
