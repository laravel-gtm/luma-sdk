<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Memberships\AddMemberRequest;
use LaravelGtm\LumaSdk\Requests\Memberships\ListMembershipTiersRequest;
use LaravelGtm\LumaSdk\Requests\Memberships\UpdateMemberStatusRequest;
use LaravelGtm\LumaSdk\Responses\AddMemberResponse;
use LaravelGtm\LumaSdk\Responses\MembershipTierResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Http\BaseResource;

class MembershipResource extends BaseResource
{
    /**
     * @return PaginatedResponse<MembershipTierResponse>
     */
    public function listTiers(ListMembershipTiersRequest $request = new ListMembershipTiersRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<MembershipTierResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    public function addMember(AddMemberRequest $request): AddMemberResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send($request)->json();

        return AddMemberResponse::fromArray($data);
    }

    public function updateMemberStatus(string $userId, string $status): void
    {
        $this->connector->send(new UpdateMemberStatusRequest($userId, $status));
    }
}
