<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Resources;

use LaravelGtm\LumaSdk\Requests\Events\AddGuestsRequest;
use LaravelGtm\LumaSdk\Requests\Events\CancelEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\CreateEventCouponRequest;
use LaravelGtm\LumaSdk\Requests\Events\CreateEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\CreateHostRequest;
use LaravelGtm\LumaSdk\Requests\Events\CreateTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\DeleteTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetGuestRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListEventCouponsRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListGuestsRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListTicketTypesRequest;
use LaravelGtm\LumaSdk\Requests\Events\RemoveHostRequest;
use LaravelGtm\LumaSdk\Requests\Events\RequestCancellationRequest;
use LaravelGtm\LumaSdk\Requests\Events\SendInvitesRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateEventCouponRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateGuestStatusRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateHostRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateTicketTypeRequest;
use LaravelGtm\LumaSdk\Responses\CancellationTokenResponse;
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

    public function requestCancellation(string $eventId): CancellationTokenResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send(new RequestCancellationRequest($eventId))->json();

        return CancellationTokenResponse::fromArray($data);
    }

    public function cancel(string $eventId, string $cancellationToken, ?bool $shouldRefund = null): void
    {
        $this->connector->send(new CancelEventRequest($eventId, $cancellationToken, $shouldRefund));
    }

    public function addGuests(AddGuestsRequest $request): void
    {
        $this->connector->send($request);
    }

    public function updateGuestStatus(UpdateGuestStatusRequest $request): void
    {
        $this->connector->send($request);
    }

    public function sendInvites(SendInvitesRequest $request): void
    {
        $this->connector->send($request);
    }

    public function createHost(CreateHostRequest $request): void
    {
        $this->connector->send($request);
    }

    public function updateHost(UpdateHostRequest $request): void
    {
        $this->connector->send($request);
    }

    public function removeHost(string $eventId, string $email): void
    {
        $this->connector->send(new RemoveHostRequest($eventId, $email));
    }

    public function createCoupon(CreateEventCouponRequest $request): string
    {
        /** @var array{coupon: array{api_id: string}} $data */
        $data = $this->connector->send($request)->json();

        return $data['coupon']['api_id'];
    }

    public function updateCoupon(UpdateEventCouponRequest $request): void
    {
        $this->connector->send($request);
    }

    public function createTicketType(CreateTicketTypeRequest $request): TicketTypeResponse
    {
        /** @var array{ticket_type: array<string, mixed>} $data */
        $data = $this->connector->send($request)->json();

        return TicketTypeResponse::fromArray($data['ticket_type']);
    }

    public function updateTicketType(UpdateTicketTypeRequest $request): TicketTypeResponse
    {
        /** @var array{ticket_type: array<string, mixed>} $data */
        $data = $this->connector->send($request)->json();

        return TicketTypeResponse::fromArray($data['ticket_type']);
    }

    public function deleteTicketType(string $eventTicketTypeApiId): void
    {
        $this->connector->send(new DeleteTicketTypeRequest($eventTicketTypeApiId));
    }
}
