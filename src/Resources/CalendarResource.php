<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Calendars\AddCalendarEventRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ApplyEventTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ApplyPersonTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\CreateCalendarCouponRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\CreateEventTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\CreatePersonTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\DeleteEventTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\DeletePersonTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\GetCalendarRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ImportPeopleRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarAdminsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarCouponsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarEventsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListEventTagsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListPeopleRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListPersonTagsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\LookupEventRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\UnapplyEventTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\UnapplyPersonTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\UpdateCalendarCouponRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\UpdateEventTagRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\UpdatePersonTagRequest;
use LaravelGtm\LumaSdk\Responses\AddEventResponse;
use LaravelGtm\LumaSdk\Responses\CalendarEventEntry;
use LaravelGtm\LumaSdk\Responses\CalendarResponse;
use LaravelGtm\LumaSdk\Responses\CouponResponse;
use LaravelGtm\LumaSdk\Responses\LookupEventResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\PersonResponse;
use LaravelGtm\LumaSdk\Responses\TagActionResponse;
use LaravelGtm\LumaSdk\Responses\TagRemoveResponse;
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

    public function addEvent(AddCalendarEventRequest $request): AddEventResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send($request)->json();

        return AddEventResponse::fromArray($data);
    }

    public function createCoupon(CreateCalendarCouponRequest $request): string
    {
        /** @var array{coupon: array{api_id: string}} $data */
        $data = $this->connector->send($request)->json();

        return $data['coupon']['api_id'];
    }

    public function updateCoupon(UpdateCalendarCouponRequest $request): void
    {
        $this->connector->send($request);
    }

    public function importPeople(ImportPeopleRequest $request): void
    {
        $this->connector->send($request);
    }

    public function createPersonTag(string $name, ?string $color = null): string
    {
        /** @var array{tag_api_id: string} $data */
        $data = $this->connector->send(new CreatePersonTagRequest($name, $color))->json();

        return $data['tag_api_id'];
    }

    public function updatePersonTag(string $tagApiId, ?string $name = null, ?string $color = null): void
    {
        $this->connector->send(new UpdatePersonTagRequest($tagApiId, $name, $color));
    }

    public function deletePersonTag(string $tagApiId): void
    {
        $this->connector->send(new DeletePersonTagRequest($tagApiId));
    }

    public function applyPersonTag(ApplyPersonTagRequest $request): TagActionResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send($request)->json();

        return TagActionResponse::fromArray($data);
    }

    public function unapplyPersonTag(UnapplyPersonTagRequest $request): TagRemoveResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send($request)->json();

        return TagRemoveResponse::fromArray($data);
    }

    public function createEventTag(string $name, ?string $color = null): string
    {
        /** @var array{tag_api_id: string} $data */
        $data = $this->connector->send(new CreateEventTagRequest($name, $color))->json();

        return $data['tag_api_id'];
    }

    public function updateEventTag(string $tagApiId, ?string $name = null, ?string $color = null): void
    {
        $this->connector->send(new UpdateEventTagRequest($tagApiId, $name, $color));
    }

    public function deleteEventTag(string $tagApiId): void
    {
        $this->connector->send(new DeleteEventTagRequest($tagApiId));
    }

    /**
     * @param  string[]  $eventApiIds
     */
    public function applyEventTag(string $tag, array $eventApiIds): TagActionResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send(new ApplyEventTagRequest($tag, $eventApiIds))->json();

        return TagActionResponse::fromArray($data);
    }

    /**
     * @param  string[]  $eventApiIds
     */
    public function unapplyEventTag(string $tag, array $eventApiIds): TagRemoveResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send(new UnapplyEventTagRequest($tag, $eventApiIds))->json();

        return TagRemoveResponse::fromArray($data);
    }
}
