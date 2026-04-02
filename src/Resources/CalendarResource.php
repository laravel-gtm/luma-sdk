<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Calendars\GetCalendarRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarAdminsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarCouponsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarEventsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListEventTagsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListPeopleRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListPersonTagsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\LookupEventRequest;
use LaravelGtm\LumaSdk\Responses\CalendarEventEntry;
use LaravelGtm\LumaSdk\Responses\CalendarResponse;
use LaravelGtm\LumaSdk\Responses\CouponResponse;
use LaravelGtm\LumaSdk\Responses\LookupEventResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\PersonResponse;
use LaravelGtm\LumaSdk\Responses\TagResponse;
use LaravelGtm\LumaSdk\Responses\UserResponse;
use Saloon\Http\BaseResource;

class CalendarResource extends BaseResource
{
    public function get(): CalendarResponse
    {
        /** @var CalendarResponse */
        return $this->connector->send(new GetCalendarRequest)->dtoOrFail();
    }

    /**
     * @return PaginatedResponse<CalendarEventEntry>
     */
    public function listEvents(ListCalendarEventsRequest $request = new ListCalendarEventsRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<CalendarEventEntry> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @return PaginatedResponse<TagResponse>
     */
    public function listPersonTags(): PaginatedResponse
    {
        /** @var PaginatedResponse<TagResponse> */
        return $this->connector->send(new ListPersonTagsRequest)->dtoOrFail();
    }

    /**
     * @return TagResponse[]
     */
    public function listEventTags(): array
    {
        /** @var TagResponse[] */
        return $this->connector->send(new ListEventTagsRequest)->dtoOrFail();
    }

    /**
     * @return UserResponse[]
     */
    public function listAdmins(): array
    {
        /** @var UserResponse[] */
        return $this->connector->send(new ListCalendarAdminsRequest)->dtoOrFail();
    }

    public function lookupEvent(LookupEventRequest $request): LookupEventResponse
    {
        /** @var LookupEventResponse */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @return PaginatedResponse<PersonResponse>
     */
    public function listPeople(ListPeopleRequest $request = new ListPeopleRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<PersonResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @return PaginatedResponse<CouponResponse>
     */
    public function listCoupons(ListCalendarCouponsRequest $request = new ListCalendarCouponsRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<CouponResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }
}
