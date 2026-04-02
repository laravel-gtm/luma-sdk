<?php

declare(strict_types=1);

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

it('add calendar event request for luma has correct endpoint and body', function (): void {
    $request = AddCalendarEventRequest::forLuma('evt_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/add-event');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['platform'])->toBe('luma');
    expect($body['event_api_id'])->toBe('evt_123');
});

it('add calendar event request for external has correct body', function (): void {
    $request = AddCalendarEventRequest::forExternal(
        url: 'https://example.test/event',
        name: 'External Event',
        startAt: '2024-06-15T18:00:00.000Z',
        durationInterval: 'PT2H',
        timezone: 'America/New_York',
    );

    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['platform'])->toBe('external');
    expect($body['url'])->toBe('https://example.test/event');
    expect($body['name'])->toBe('External Event');
});

it('create calendar coupon request has correct endpoint', function (): void {
    $request = new CreateCalendarCouponRequest(
        code: 'SAVE10',
        discount: ['discount_type' => 'percent', 'percent_off' => 10],
    );

    expect($request->resolveEndpoint())->toBe('/v1/calendar/coupons/create');
});

it('update calendar coupon request has correct endpoint', function (): void {
    $request = new UpdateCalendarCouponRequest('SAVE10');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/coupons/update');
});

it('import people request has correct endpoint and body', function (): void {
    $request = new ImportPeopleRequest(
        infos: [['email' => 'test@example.test', 'name' => 'Test']],
        tagApiIds: ['tag_1'],
    );

    expect($request->resolveEndpoint())->toBe('/v1/calendar/import-people');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['infos'])->toHaveCount(1);
    expect($body['tag_api_ids'])->toBe(['tag_1']);
});

it('create person tag request has correct endpoint', function (): void {
    $request = new CreatePersonTagRequest('VIP', 'blue');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/create-person-tag');
});

it('update person tag request has correct endpoint', function (): void {
    $request = new UpdatePersonTagRequest('tag_123', name: 'Updated');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/update-person-tag');
});

it('delete person tag request has correct endpoint', function (): void {
    $request = new DeletePersonTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/delete-person-tag');
});

it('apply person tag request has correct endpoint', function (): void {
    $request = new ApplyPersonTagRequest('tag_123', emails: ['test@example.test']);

    expect($request->resolveEndpoint())->toBe('/v1/calendar/person-tags/apply');
});

it('unapply person tag request has correct endpoint', function (): void {
    $request = new UnapplyPersonTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/person-tags/unapply');
});

it('create event tag request has correct endpoint', function (): void {
    $request = new CreateEventTagRequest('Workshop');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/create');
});

it('update event tag request has correct endpoint', function (): void {
    $request = new UpdateEventTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/update');
});

it('delete event tag request has correct endpoint', function (): void {
    $request = new DeleteEventTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/delete');
});

it('apply event tag request has correct endpoint and body', function (): void {
    $request = new ApplyEventTagRequest('tag_123', ['evt_1', 'evt_2']);

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/apply');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['event_api_ids'])->toBe(['evt_1', 'evt_2']);
});

it('unapply event tag request has correct endpoint', function (): void {
    $request = new UnapplyEventTagRequest('tag_123', ['evt_1']);

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/unapply');
});
