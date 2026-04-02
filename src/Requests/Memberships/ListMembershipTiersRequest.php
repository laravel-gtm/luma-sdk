<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests\Memberships;

use LaravelGtm\LumaSdk\Responses\MembershipTierResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Lists membership tiers.
 *
 * `GET /v1/memberships/tiers/list`
 */
class ListMembershipTiersRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $paginationCursor = null,
        private readonly ?int $paginationLimit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/memberships/tiers/list';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'pagination_cursor' => $this->paginationCursor,
            'pagination_limit' => $this->paginationLimit,
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<MembershipTierResponse>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        /** @var array<string, mixed> $data */
        $data = $response->json();

        return PaginatedResponse::fromArray($data, MembershipTierResponse::fromArray(...));
    }
}
