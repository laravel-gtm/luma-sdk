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
    /**
     * Gets a single event by API id.
     *
     * @see GetEventRequest
     */
    public function get(string $id): GetEventResponse
    {
        /** @var GetEventResponse */
        return $this->connector->send(new GetEventRequest($id))->dtoOrFail();
    }

    /**
     * Creates an event and returns its API id.
     *
     * @see CreateEventRequest
     */
    public function create(CreateEventRequest $request): string
    {
        /** @var array{api_id: string} $data */
        $data = $this->connector->send($request)->json();

        return $data['api_id'];
    }

    /**
     * Updates an event and returns its API id.
     *
     * @see UpdateEventRequest
     */
    public function update(UpdateEventRequest $request): string
    {
        /** @var array{api_id: string} $data */
        $data = $this->connector->send($request)->json();

        return $data['api_id'];
    }

    /**
     * Gets a specific guest.
     *
     * @param  string|null  $eventId  Event API id when lookup is event-scoped.
     * @param  string|null  $id  Guest API id.
     *
     * @see GetGuestRequest
     */
    public function getGuest(?string $eventId = null, ?string $id = null): GuestResponse
    {
        /** @var GuestResponse */
        return $this->connector->send(new GetGuestRequest($eventId, $id))->dtoOrFail();
    }

    /**
     * Lists guests with pagination.
     *
     * @return PaginatedResponse<GuestResponse>
     *
     * @see ListGuestsRequest
     */
    public function listGuests(ListGuestsRequest $request): PaginatedResponse
    {
        /** @var PaginatedResponse<GuestResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * Lists event coupons with pagination.
     *
     * @return PaginatedResponse<CouponResponse>
     *
     * @see ListEventCouponsRequest
     */
    public function listCoupons(ListEventCouponsRequest $request): PaginatedResponse
    {
        /** @var PaginatedResponse<CouponResponse> */
        return $this->connector->send($request)->dtoOrFail();
    }

    /**
     * Lists ticket types for an event.
     *
     * @param  string|null  $includeHidden  Optional flag expected by the API (`true`/`false`).
     *
     * @return TicketTypeResponse[]
     *
     * @see ListTicketTypesRequest
     */
    public function listTicketTypes(string $eventId, ?string $includeHidden = null): array
    {
        /** @var TicketTypeResponse[] */
        return $this->connector->send(new ListTicketTypesRequest($eventId, $includeHidden))->dtoOrFail();
    }

    /**
     * Gets a ticket type by API id.
     *
     * @see GetTicketTypeRequest
     */
    public function getTicketType(string $id): TicketTypeResponse
    {
        /** @var TicketTypeResponse */
        return $this->connector->send(new GetTicketTypeRequest($id))->dtoOrFail();
    }

    /**
     * Starts event cancellation and returns a cancellation token.
     *
     * @see RequestCancellationRequest
     */
    public function requestCancellation(string $eventId): CancellationTokenResponse
    {
        /** @var array<string, mixed> $data */
        $data = $this->connector->send(new RequestCancellationRequest($eventId))->json();

        return CancellationTokenResponse::fromArray($data);
    }

    /**
     * Cancels an event using a cancellation token.
     *
     * @param  bool|null  $shouldRefund  Whether guests should be refunded when supported.
     *
     * @see CancelEventRequest
     */
    public function cancel(string $eventId, string $cancellationToken, ?bool $shouldRefund = null): void
    {
        $this->connector->send(new CancelEventRequest($eventId, $cancellationToken, $shouldRefund));
    }

    /**
     * Adds guests to an event.
     *
     * @see AddGuestsRequest
     */
    public function addGuests(AddGuestsRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Updates status for one or more guests.
     *
     * @see UpdateGuestStatusRequest
     */
    public function updateGuestStatus(UpdateGuestStatusRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Sends invitations to event guests.
     *
     * @see SendInvitesRequest
     */
    public function sendInvites(SendInvitesRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Creates a host for an event.
     *
     * @see CreateHostRequest
     */
    public function createHost(CreateHostRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Updates host access settings.
     *
     * @see UpdateHostRequest
     */
    public function updateHost(UpdateHostRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Removes a host from an event by email.
     *
     * @see RemoveHostRequest
     */
    public function removeHost(string $eventId, string $email): void
    {
        $this->connector->send(new RemoveHostRequest($eventId, $email));
    }

    /**
     * Creates an event coupon and returns its API id.
     *
     * @see CreateEventCouponRequest
     */
    public function createCoupon(CreateEventCouponRequest $request): string
    {
        /** @var array{coupon: array{api_id: string}} $data */
        $data = $this->connector->send($request)->json();

        return $data['coupon']['api_id'];
    }

    /**
     * Updates an event coupon.
     *
     * @see UpdateEventCouponRequest
     */
    public function updateCoupon(UpdateEventCouponRequest $request): void
    {
        $this->connector->send($request);
    }

    /**
     * Creates a ticket type.
     *
     * @see CreateTicketTypeRequest
     */
    public function createTicketType(CreateTicketTypeRequest $request): TicketTypeResponse
    {
        /** @var array{ticket_type: array<string, mixed>} $data */
        $data = $this->connector->send($request)->json();

        return TicketTypeResponse::fromArray($data['ticket_type']);
    }

    /**
     * Updates a ticket type.
     *
     * @see UpdateTicketTypeRequest
     */
    public function updateTicketType(UpdateTicketTypeRequest $request): TicketTypeResponse
    {
        /** @var array{ticket_type: array<string, mixed>} $data */
        $data = $this->connector->send($request)->json();

        return TicketTypeResponse::fromArray($data['ticket_type']);
    }

    /**
     * Deletes a ticket type by API id.
     *
     * @see DeleteTicketTypeRequest
     */
    public function deleteTicketType(string $eventTicketTypeApiId): void
    {
        $this->connector->send(new DeleteTicketTypeRequest($eventTicketTypeApiId));
    }
}
