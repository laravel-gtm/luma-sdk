<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests;

use LaravelGtm\LumaSdk\Responses\UserResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Retrieves the authenticated user.
 *
 * `GET /v1/user/get-self`
 */
class GetSelfRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/user/get-self';
    }

    public function createDtoFromResponse(Response $response): UserResponse
    {
        /** @var array{user: array<string, mixed>} $data */
        $data = $response->json();

        return UserResponse::fromArray($data['user']);
    }
}
