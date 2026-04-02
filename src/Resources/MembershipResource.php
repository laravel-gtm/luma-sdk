<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Memberships\ListMembershipTiersRequest;
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
}
