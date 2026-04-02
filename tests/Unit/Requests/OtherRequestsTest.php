<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Requests\LookupEntityRequest;
use LaravelGtm\LumaSdk\Requests\Memberships\ListMembershipTiersRequest;
use LaravelGtm\LumaSdk\Requests\Organizations\ListOrgCalendarsRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\GetWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\ListWebhooksRequest;
use Saloon\Enums\Method;

it('lookup entity request has correct endpoint and query', function (): void {
    $request = new LookupEntityRequest('my-event');

    expect($request->resolveEndpoint())->toBe('/v1/entity/lookup');
    $method = new ReflectionMethod($request, 'defaultQuery');
    expect($method->invoke($request))->toBe(['slug' => 'my-event']);
});

it('list membership tiers request has correct endpoint', function (): void {
    $request = new ListMembershipTiersRequest;

    expect($request->resolveEndpoint())->toBe('/v1/memberships/tiers/list');
});

it('list webhooks request has correct endpoint', function (): void {
    $request = new ListWebhooksRequest;

    expect($request->resolveEndpoint())->toBe('/v1/webhooks/list');
});

it('get webhook request has correct endpoint and query', function (): void {
    $request = new GetWebhookRequest('wh_123');

    expect($request->resolveEndpoint())->toBe('/v1/webhooks/get');
    $method = new ReflectionMethod($request, 'defaultQuery');
    expect($method->invoke($request))->toBe(['id' => 'wh_123']);
});

it('list org calendars request has correct endpoint', function (): void {
    $request = new ListOrgCalendarsRequest;

    expect($request->resolveEndpoint())->toBe('/v1/organizations/calendars/list');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::GET);
});
