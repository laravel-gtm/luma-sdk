<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\HostAccessLevel;
use LaravelGtm\LumaSdk\Enums\Visibility;
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
use Saloon\Enums\Method;

it('get event request has correct method and endpoint', function (): void {
    $request = new GetEventRequest('evt_123');

    expect($request->resolveEndpoint())->toBe('/v1/event/get');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('get event request includes id in query', function (): void {
    $request = new GetEventRequest('evt_123');
    $method = new ReflectionMethod($request, 'defaultQuery');

    expect($method->invoke($request))->toBe(['id' => 'evt_123']);
});

it('create event request has correct method and endpoint', function (): void {
    $request = new CreateEventRequest(
        name: 'Test Event',
        startAt: '2024-06-15T18:00:00.000Z',
        timezone: 'America/New_York',
    );

    expect($request->resolveEndpoint())->toBe('/v1/event/create');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
});

it('create event request builds correct body', function (): void {
    $request = new CreateEventRequest(
        name: 'Test Event',
        startAt: '2024-06-15T18:00:00.000Z',
        timezone: 'America/New_York',
        visibility: Visibility::Public,
        maxCapacity: 100,
    );

    $method = new ReflectionMethod($request, 'defaultBody');
    $body = $method->invoke($request);

    expect($body['name'])->toBe('Test Event');
    expect($body['start_at'])->toBe('2024-06-15T18:00:00.000Z');
    expect($body['timezone'])->toBe('America/New_York');
    expect($body['visibility'])->toBe('public');
    expect($body['max_capacity'])->toBe(100);
    expect($body)->not->toHaveKey('end_at');
});

it('update event request includes event api id in body', function (): void {
    $request = new UpdateEventRequest(
        eventApiId: 'evt_123',
        name: 'Updated Event',
    );

    $method = new ReflectionMethod($request, 'defaultBody');
    $body = $method->invoke($request);

    expect($body['event_api_id'])->toBe('evt_123');
    expect($body['name'])->toBe('Updated Event');
    expect($request->resolveEndpoint())->toBe('/v1/event/update');
});

it('get guest request has correct endpoint', function (): void {
    $request = new GetGuestRequest(eventId: 'evt_123', id: 'gst_456');

    expect($request->resolveEndpoint())->toBe('/v1/event/get-guest');
});

it('list guests request has correct endpoint', function (): void {
    $request = new ListGuestsRequest('evt_123');

    expect($request->resolveEndpoint())->toBe('/v1/event/get-guests');
});

it('list event coupons request has correct endpoint', function (): void {
    $request = new ListEventCouponsRequest('evt_123');

    expect($request->resolveEndpoint())->toBe('/v1/event/coupons');
});

it('list ticket types request has correct endpoint', function (): void {
    $request = new ListTicketTypesRequest('evt_123');

    expect($request->resolveEndpoint())->toBe('/v1/event/ticket-types/list');
});

it('get ticket type request has correct endpoint', function (): void {
    $request = new GetTicketTypeRequest('tt_123');

    expect($request->resolveEndpoint())->toBe('/v1/event/ticket-types/get');
});

it('request cancellation request has correct method and endpoint', function (): void {
    $request = new RequestCancellationRequest('evt_123');

    expect($request->resolveEndpoint())->toBe('/v1/event/cancel/request');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
});

it('cancel event request has correct endpoint and body', function (): void {
    $request = new CancelEventRequest('evt_123', 'token_abc', true);

    expect($request->resolveEndpoint())->toBe('/v1/event/cancel');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['event_id'])->toBe('evt_123');
    expect($body['cancellation_token'])->toBe('token_abc');
    expect($body['should_refund'])->toBeTrue();
});

it('add guests request has correct endpoint and body', function (): void {
    $request = new AddGuestsRequest(
        eventApiId: 'evt_123',
        guests: [['email' => 'test@example.test']],
        ticket: ['event_ticket_type_id' => 'tt_1'],
    );

    expect($request->resolveEndpoint())->toBe('/v1/event/add-guests');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['event_api_id'])->toBe('evt_123');
    expect($body['guests'])->toHaveCount(1);
    expect($body['ticket']['event_ticket_type_id'])->toBe('tt_1');
    expect($body)->not->toHaveKey('tickets');
});

it('update guest status request has correct endpoint', function (): void {
    $request = new UpdateGuestStatusRequest(
        guest: ['type' => 'email', 'email' => 'test@example.test'],
        eventApiId: 'evt_123',
        status: 'approved',
    );

    expect($request->resolveEndpoint())->toBe('/v1/event/update-guest-status');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['status'])->toBe('approved');
});

it('send invites request has correct endpoint', function (): void {
    $request = new SendInvitesRequest(
        eventApiId: 'evt_123',
        guests: [['email' => 'test@example.test']],
        message: 'Welcome!',
    );

    expect($request->resolveEndpoint())->toBe('/v1/event/send-invites');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['message'])->toBe('Welcome!');
});

it('create host request has correct endpoint and body', function (): void {
    $request = new CreateHostRequest(
        eventId: 'evt_123',
        email: 'host@example.test',
        accessLevel: HostAccessLevel::Manager,
    );

    expect($request->resolveEndpoint())->toBe('/v1/event/hosts/create');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['access_level'])->toBe('manager');
});

it('update host request has correct endpoint', function (): void {
    $request = new UpdateHostRequest('evt_123', 'host@example.test');

    expect($request->resolveEndpoint())->toBe('/v1/event/hosts/update');
});

it('remove host request has correct endpoint', function (): void {
    $request = new RemoveHostRequest('evt_123', 'host@example.test');

    expect($request->resolveEndpoint())->toBe('/v1/event/hosts/remove');
});

it('create event coupon request has correct endpoint and body', function (): void {
    $request = new CreateEventCouponRequest(
        eventApiId: 'evt_123',
        code: 'SAVE20',
        discount: ['discount_type' => 'percent', 'percent_off' => 20],
    );

    expect($request->resolveEndpoint())->toBe('/v1/event/create-coupon');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['code'])->toBe('SAVE20');
    expect($body['discount']['percent_off'])->toBe(20);
});

it('update event coupon request has correct endpoint', function (): void {
    $request = new UpdateEventCouponRequest('evt_123', 'SAVE20');

    expect($request->resolveEndpoint())->toBe('/v1/event/update-coupon');
});

it('create ticket type request has correct endpoint and body', function (): void {
    $request = new CreateTicketTypeRequest(
        eventApiId: 'evt_123',
        name: 'VIP',
        type: 'paid',
        cents: 5000,
        currency: 'usd',
    );

    expect($request->resolveEndpoint())->toBe('/v1/event/ticket-types/create');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['name'])->toBe('VIP');
    expect($body['cents'])->toBe(5000);
});

it('update ticket type request has correct endpoint', function (): void {
    $request = new UpdateTicketTypeRequest('tt_123', name: 'Updated');

    expect($request->resolveEndpoint())->toBe('/v1/event/ticket-types/update');
});

it('delete ticket type request has correct endpoint and body', function (): void {
    $request = new DeleteTicketTypeRequest('tt_123');

    expect($request->resolveEndpoint())->toBe('/v1/event/ticket-types/delete');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['event_ticket_type_api_id'])->toBe('tt_123');
});
