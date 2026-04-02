<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Organizations\ListOrgCalendarsRequest;
use LaravelGtm\LumaSdk\Responses\CalendarResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use Saloon\Http\BaseResource;

class OrganizationResource extends BaseResource
{
    /**
     * Lists calendars within the authenticated organization.
     *
     * @return PaginatedResponse<CalendarResponse>
     *
     * @see ListOrgCalendarsRequest
     */
    public function listCalendars(ListOrgCalendarsRequest $request = new ListOrgCalendarsRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<CalendarResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }
}
