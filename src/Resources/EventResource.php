<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Events\CreateEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetGuestRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListEventCouponsRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListGuestsRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListTicketTypesRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateEventRequest;
use LaravelGtm\LumaSdk\Responses\CouponResponse;
use LaravelGtm\LumaSdk\Responses\GetEventResponse;
use LaravelGtm\LumaSdk\Responses\GuestResponse;
use LaravelGtm\LumaSdk\Responses\PaginatedResponse;
use LaravelGtm\LumaSdk\Responses\TicketTypeResponse;
use Saloon\Http\BaseResource;

class EventResource extends BaseResource
{
    public function get(string $id): GetEventResponse
    {
        /** @var GetEventResponse */
        return $this->connector->send(new GetEventRequest($id))->dtoOrFail();
    }

    public function create(CreateEventRequest $request): string
    {
        /** @var array{api_id: string} $data */
        $data = $this->connector->send($request)->json();

        return $data['api_id'];
    }

    public function update(UpdateEventRequest $request): string
    {
        /** @var array{api_id: string} $data */
        $data = $this->connector->send($request)->json();

        return $data['api_id'];
    }

    public function getGuest(?string $eventId = null, ?string $id = null): GuestResponse
    {
        /** @var GuestResponse */
        return $this->connector->send(new GetGuestRequest($eventId, $id))->dtoOrFail();
    }

    /**
     * @return PaginatedResponse<GuestResponse>
     */
    public function listGuests(ListGuestsRequest $request): PaginatedResponse
    {
        /** @var PaginatedResponse<GuestResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @return PaginatedResponse<CouponResponse>
     */
    public function listCoupons(ListEventCouponsRequest $request): PaginatedResponse
    {
        /** @var PaginatedResponse<CouponResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * @return TicketTypeResponse[]
     */
    public function listTicketTypes(string $eventId, ?string $includeHidden = null): array
    {
        /** @var TicketTypeResponse[] */
        return $this->connector->send(new ListTicketTypesRequest($eventId, $includeHidden))->dtoOrFail();
    }

    public function getTicketType(string $id): TicketTypeResponse
    {
        /** @var TicketTypeResponse */
        return $this->connector->send(new GetTicketTypeRequest($id))->dtoOrFail();
    }
}
