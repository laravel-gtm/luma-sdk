<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\WebhookStatus;
use LaravelGtm\LumaSdk\Requests\Images\CreateUploadUrlRequest;
use LaravelGtm\LumaSdk\Requests\LookupEntityRequest;
use LaravelGtm\LumaSdk\Requests\Memberships\AddMemberRequest;
use LaravelGtm\LumaSdk\Requests\Memberships\ListMembershipTiersRequest;
use LaravelGtm\LumaSdk\Requests\Memberships\UpdateMemberStatusRequest;
use LaravelGtm\LumaSdk\Requests\Organizations\ListOrgCalendarsRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\CreateWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\DeleteWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\GetWebhookRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\ListWebhooksRequest;
use LaravelGtm\LumaSdk\Requests\Webhooks\UpdateWebhookRequest;
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

it('create webhook request has correct endpoint and body', function (): void {
    $request = new CreateWebhookRequest(
        'https://example.test/hook',
        ['event.created'],
    );

    expect($request->resolveEndpoint())->toBe('/v1/webhooks/create');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['url'])->toBe('https://example.test/hook');
    expect($body['event_types'])->toBe(['event.created']);
});

it('update webhook request has correct endpoint', function (): void {
    $request = new UpdateWebhookRequest(
        id: 'wh_123',
        status: WebhookStatus::Paused,
    );

    expect($request->resolveEndpoint())->toBe('/v1/webhooks/update');
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['status'])->toBe('paused');
});

it('delete webhook request has correct endpoint', function (): void {
    $request = new DeleteWebhookRequest('wh_123');

    expect($request->resolveEndpoint())->toBe('/v1/webhooks/delete');
});

it('add member request has correct endpoint and body', function (): void {
    $request = new AddMemberRequest(
        email: 'member@example.test',
        membershipTierId: 'tier_123',
        skipPayment: true,
    );

    expect($request->resolveEndpoint())->toBe('/v1/memberships/members/add');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['email'])->toBe('member@example.test');
    expect($body['skip_payment'])->toBeTrue();
});

it('update member status request has correct endpoint', function (): void {
    $request = new UpdateMemberStatusRequest('usr_123', 'approved');

    expect($request->resolveEndpoint())->toBe('/v1/memberships/members/update-status');
});

it('create upload url request has correct endpoint and body', function (): void {
    $request = new CreateUploadUrlRequest('event-cover', 'image/png');

    expect($request->resolveEndpoint())->toBe('/v1/images/create-upload-url');
    expect((new ReflectionProperty($request, 'method'))->getValue($request))->toBe(Method::POST);
    $body = (new ReflectionMethod($request, 'defaultBody'))->invoke($request);
    expect($body['purpose'])->toBe('event-cover');
    expect($body['content_type'])->toBe('image/png');
});
