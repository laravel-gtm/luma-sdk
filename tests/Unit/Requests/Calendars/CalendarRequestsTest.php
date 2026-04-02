<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Requests\Calendars\GetCalendarRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarAdminsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarCouponsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListCalendarEventsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListEventTagsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListPeopleRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\ListPersonTagsRequest;
use LaravelGtm\LumaSdk\Requests\Calendars\LookupEventRequest;
use Saloon\Enums\Method;

it('get calendar request has correct endpoint', function (): void {
    $request = new GetCalendarRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/get');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('list calendar events request has correct endpoint', function (): void {
    $request = new ListCalendarEventsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/list-events');
});

it('list calendar events request includes query params', function (): void {
    $request = new ListCalendarEventsRequest(
        after: '2024-01-01T00:00:00.000Z',
        paginationLimit: 10,
    );

    $method = new ReflectionMethod($request, 'defaultQuery');
    $query = $method->invoke($request);

    expect($query['after'])->toBe('2024-01-01T00:00:00.000Z');
    expect($query['pagination_limit'])->toBe(10);
    expect($query)->not->toHaveKey('before');
});

it('list person tags request has correct endpoint', function (): void {
    $request = new ListPersonTagsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/list-person-tags');
});

it('list event tags request has correct endpoint', function (): void {
    $request = new ListEventTagsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/list');
});

it('list calendar admins request has correct endpoint', function (): void {
    $request = new ListCalendarAdminsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/admins/list');
});

it('lookup event request has correct endpoint', function (): void {
    $request = new LookupEventRequest(url: 'https://example.test/event');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/lookup-event');
});

it('list people request has correct endpoint', function (): void {
    $request = new ListPeopleRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/list-people');
});

it('list calendar coupons request has correct endpoint', function (): void {
    $request = new ListCalendarCouponsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/coupons');
});
