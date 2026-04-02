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
    /**
     * Gets the authenticated calendar.
     *
     * @see GetCalendarRequest
     */
    public function get(): CalendarResponse
    {
        /** @var CalendarResponse */
        return $this->connector->send(new GetCalendarRequest)->dtoOrFail();
    }

    /**
     * Lists calendar events with pagination.
     *
     * @return PaginatedResponse<CalendarEventEntry>
     *
     * @see ListCalendarEventsRequest
     */
    public function listEvents(ListCalendarEventsRequest $request = new ListCalendarEventsRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<CalendarEventEntry> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * Lists person tags available on the calendar.
     *
     * @return PaginatedResponse<TagResponse>
     *
     * @see ListPersonTagsRequest
     */
    public function listPersonTags(): PaginatedResponse
    {
        /** @var PaginatedResponse<TagResponse> */
        return $this->connector->send(new ListPersonTagsRequest)->dtoOrFail();
    }

    /**
     * Lists event tags available on the calendar.
     *
     * @return TagResponse[]
     *
     * @see ListEventTagsRequest
     */
    public function listEventTags(): array
    {
        /** @var TagResponse[] */
        return $this->connector->send(new ListEventTagsRequest)->dtoOrFail();
    }

    /**
     * Lists calendar admins.
     *
     * @return UserResponse[]
     *
     * @see ListCalendarAdminsRequest
     */
    public function listAdmins(): array
    {
        /** @var UserResponse[] */
        return $this->connector->send(new ListCalendarAdminsRequest)->dtoOrFail();
    }

    /**
     * Resolves a calendar event from a URL or slug context.
     *
     * @see LookupEventRequest
     */
    public function lookupEvent(LookupEventRequest $request): LookupEventResponse
    {
        /** @var LookupEventResponse */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * Lists people with pagination.
     *
     * @return PaginatedResponse<PersonResponse>
     *
     * @see ListPeopleRequest
     */
    public function listPeople(ListPeopleRequest $request = new ListPeopleRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<PersonResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * Lists calendar coupons with pagination.
     *
     * @return PaginatedResponse<CouponResponse>
     *
     * @see ListCalendarCouponsRequest
     */
    public function listCoupons(ListCalendarCouponsRequest $request = new ListCalendarCouponsRequest): PaginatedResponse
    {
        /** @var PaginatedResponse<CouponResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * Adds an event to the calendar from an external source or existing Luma event.
     *
     * @see AddCalendarEventRequest
     */
    public function addEvent(AddCalendarEventRequest $request): AddEventResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send($request)->json();

        return AddEventResponse::fromArray($data);
    }

    /**
     * Creates a calendar coupon and returns its API id.
     *
     * @see CreateCalendarCouponRequest
     */
    public function createCoupon(CreateCalendarCouponRequest $request): string
    {
        /** @var array{coupon: array{api_id: string}} $data */
        $data = $this->connector->send($request)->json();

        return $data['coupon']['api_id'];
    }

    /**
     * Updates a calendar coupon.
     *
     * @see UpdateCalendarCouponRequest
     */
    public function updateCoupon(UpdateCalendarCouponRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Imports people into the calendar.
     *
     * @see ImportPeopleRequest
     */
    public function importPeople(ImportPeopleRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Creates a person tag and returns its API id.
     *
     * @see CreatePersonTagRequest
     */
    public function createPersonTag(string $name, ?string $color = null): string
    {
        /** @var array{tag_api_id: string} $data */
        $data = $this->connector->send(new CreatePersonTagRequest($name, $color))->json();

        return $data['tag_api_id'];
    }

    /**
     * Updates a person tag.
     *
     * @see UpdatePersonTagRequest
     */
    public function updatePersonTag(string $tagApiId, ?string $name = null, ?string $color = null): void
    {
        $this->connector->send(new UpdatePersonTagRequest($tagApiId, $name, $color));
    }

    /**
     * Deletes a person tag.
     *
     * @see DeletePersonTagRequest
     */
    public function deletePersonTag(string $tagApiId): void
    {
        $this->connector->send(new DeletePersonTagRequest($tagApiId));
    }

    /**
     * Applies a person tag.
     *
     * @see ApplyPersonTagRequest
     */
    public function applyPersonTag(ApplyPersonTagRequest $request): TagActionResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send($request)->json();

        return TagActionResponse::fromArray($data);
    }

    /**
     * Removes a person tag.
     *
     * @see UnapplyPersonTagRequest
     */
    public function unapplyPersonTag(UnapplyPersonTagRequest $request): TagRemoveResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send($request)->json();

        return TagRemoveResponse::fromArray($data);
    }

    /**
     * Creates an event tag and returns its API id.
     *
     * @see CreateEventTagRequest
     */
    public function createEventTag(string $name, ?string $color = null): string
    {
        /** @var array{tag_api_id: string} $data */
        $data = $this->connector->send(new CreateEventTagRequest($name, $color))->json();

        return $data['tag_api_id'];
    }

    /**
     * Updates an event tag.
     *
     * @see UpdateEventTagRequest
     */
    public function updateEventTag(string $tagApiId, ?string $name = null, ?string $color = null): void
    {
        $this->connector->send(new UpdateEventTagRequest($tagApiId, $name, $color));
    }

    /**
     * Deletes an event tag.
     *
     * @see DeleteEventTagRequest
     */
    public function deleteEventTag(string $tagApiId): void
    {
        $this->connector->send(new DeleteEventTagRequest($tagApiId));
    }

    /**
     * Applies an event tag to multiple events.
     *
     * @param  string[]  $eventApiIds
     *
     * @see ApplyEventTagRequest
     */
    public function applyEventTag(string $tag, array $eventApiIds): TagActionResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send(new ApplyEventTagRequest($tag, $eventApiIds))->json();

        return TagActionResponse::fromArray($data);
    }

    /**
     * Removes an event tag from multiple events.
     *
     * @param  string[]  $eventApiIds
     *
     * @see UnapplyEventTagRequest
     */
    public function unapplyEventTag(string $tag, array $eventApiIds): TagRemoveResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send(new UnapplyEventTagRequest($tag, $eventApiIds))->json();

        return TagRemoveResponse::fromArray($data);
    }
}
