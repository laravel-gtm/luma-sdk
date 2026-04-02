<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\Visibility;
use LaravelGtm\LumaSdk\Requests\Events\CreateEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetEventRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetGuestRequest;
use LaravelGtm\LumaSdk\Requests\Events\GetTicketTypeRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListEventCouponsRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListGuestsRequest;
use LaravelGtm\LumaSdk\Requests\Events\ListTicketTypesRequest;
use LaravelGtm\LumaSdk\Requests\Events\UpdateEventRequest;
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
