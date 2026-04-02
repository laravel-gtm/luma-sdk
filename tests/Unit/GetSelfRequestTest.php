<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Requests\GetSelfRequest;
use Saloon\Enums\Method;

it('uses a GET method', function (): void {
    $request = new GetSelfRequest;
    $property = new ReflectionProperty(GetSelfRequest::class, 'method');

    expect($property->getValue($request))->toBe(Method::GET);
});

it('targets the get-self endpoint', function (): void {
    $request = new GetSelfRequest;

    expect($request->resolveEndpoint())->toBe('/v1/user/get-self');
});
