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
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;
use LaravelGtm\LumaSdk\ValueObjects\LumaDuration;
use Saloon\Enums\Method;

it('get calendar request has correct method and endpoint', function (): void {
    $request = new GetCalendarRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/get');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('list calendar events request has correct method and endpoint', function (): void {
    $request = new ListCalendarEventsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/list-events');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
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

it('list person tags request has correct method and endpoint', function (): void {
    $request = new ListPersonTagsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/list-person-tags');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('list event tags request has correct method and endpoint', function (): void {
    $request = new ListEventTagsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/list');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('list calendar admins request has correct method and endpoint', function (): void {
    $request = new ListCalendarAdminsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/admins/list');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('lookup event request has correct method and endpoint', function (): void {
    $request = new LookupEventRequest(url: 'https://example.test/event');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/lookup-event');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
    $query = (new ReflectionMethod($request, 'defaultQuery'))->invoke($request);
    expect($query['url'])->toBe('https://example.test/event');
});

it('list people request has correct method and endpoint', function (): void {
    $request = new ListPeopleRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/list-people');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('list calendar coupons request has correct method and endpoint', function (): void {
    $request = new ListCalendarCouponsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/calendar/coupons');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});

it('add calendar event request for luma has correct method, endpoint and body', function (): void {
    $request = AddCalendarEventRequest::forLuma('evt_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/add-event');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['platform'])->toBe('luma');
    expect($body['event_api_id'])->toBe('evt_123');
});

it('add calendar event request for external has correct method and body', function (): void {
    $request = AddCalendarEventRequest::forExternal(
        url: 'https://example.test/event',
        name: 'External Event',
        startAt: LumaDate::fromString('2024-06-15T18:00:00.000Z'),
        durationInterval: LumaDuration::fromString('PT2H'),
        timezone: 'America/New_York',
    );

    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['platform'])->toBe('external');
    expect($body['url'])->toBe('https://example.test/event');
    expect($body['name'])->toBe('External Event');
    expect($body['start_at'])->toBe('2024-06-15T18:00:00.000Z');
    expect($body['duration_interval'])->toBe('PT2H');
});

it('create calendar coupon request has correct method, endpoint and body', function (): void {
    $request = new CreateCalendarCouponRequest(
        code: 'SAVE10',
        discount: ['discount_type' => 'percent', 'percent_off' => 10],
    );

    expect($request->resolveEndpoint())->toBe('/v1/calendar/coupons/create');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['code'])->toBe('SAVE10');
    expect($body['discount']['percent_off'])->toBe(10);
});

it('update calendar coupon request has correct method, endpoint and body', function (): void {
    $request = new UpdateCalendarCouponRequest('SAVE10');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/coupons/update');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['code'])->toBe('SAVE10');
});

it('import people request has correct method, endpoint and body', function (): void {
    $request = new ImportPeopleRequest(
        infos: [['email' => 'test@example.test', 'name' => 'Test']],
        tagApiIds: ['tag_1'],
    );

    expect($request->resolveEndpoint())->toBe('/v1/calendar/import-people');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['infos'])->toHaveCount(1);
    expect($body['tag_api_ids'])->toBe(['tag_1']);
});

it('create person tag request has correct method, endpoint and body', function (): void {
    $request = new CreatePersonTagRequest('VIP', 'blue');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/create-person-tag');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['name'])->toBe('VIP');
    expect($body['color'])->toBe('blue');
});

it('update person tag request has correct method, endpoint and body', function (): void {
    $request = new UpdatePersonTagRequest('tag_123', name: 'Updated');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/update-person-tag');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag_api_id'])->toBe('tag_123');
    expect($body['name'])->toBe('Updated');
});

it('delete person tag request has correct method, endpoint and body', function (): void {
    $request = new DeletePersonTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/delete-person-tag');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag_api_id'])->toBe('tag_123');
});

it('apply person tag request has correct method, endpoint and body', function (): void {
    $request = new ApplyPersonTagRequest('tag_123', emails: ['test@example.test']);

    expect($request->resolveEndpoint())->toBe('/v1/calendar/person-tags/apply');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag'])->toBe('tag_123');
    expect($body['emails'])->toBe(['test@example.test']);
});

it('unapply person tag request has correct method, endpoint and body', function (): void {
    $request = new UnapplyPersonTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/person-tags/unapply');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag'])->toBe('tag_123');
});

it('create event tag request has correct method, endpoint and body', function (): void {
    $request = new CreateEventTagRequest('Workshop');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/create');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['name'])->toBe('Workshop');
});

it('update event tag request has correct method, endpoint and body', function (): void {
    $request = new UpdateEventTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/update');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag_api_id'])->toBe('tag_123');
});

it('delete event tag request has correct method, endpoint and body', function (): void {
    $request = new DeleteEventTagRequest('tag_123');

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/delete');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag_api_id'])->toBe('tag_123');
});

it('apply event tag request has correct method, endpoint and body', function (): void {
    $request = new ApplyEventTagRequest('tag_123', ['evt_1', 'evt_2']);

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/apply');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag'])->toBe('tag_123');
    expect($body['event_api_ids'])->toBe(['evt_1', 'evt_2']);
});

it('unapply event tag request has correct method, endpoint and body', function (): void {
    $request = new UnapplyEventTagRequest('tag_123', ['evt_1']);

    expect($request->resolveEndpoint())->toBe('/v1/calendar/event-tags/unapply');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['tag'])->toBe('tag_123');
    expect($body['event_api_ids'])->toBe(['evt_1']);
});
