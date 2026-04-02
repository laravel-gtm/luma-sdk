<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests;

use LaravelGtm\LumaSdk\Responses\EntityResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class LookupEntityRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $slug,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/entity/lookup';
    }

    protected function defaultQuery(): array
    {
        return ['slug' => $this->slug];
    }

    public function createDtoFromResponse(Response $response): EntityResponse
    {
        /** @var array{entity: array<string, mixed>} $data */
        $data = $response->json();

        return EntityResponse::fromArray($data['entity']);
    }
}
