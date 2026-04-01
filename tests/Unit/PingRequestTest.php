<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Requests\PingRequest;
use Saloon\Enums\Method;

it('uses a GET method', function (): void {
    $request = new PingRequest;
    $property = new ReflectionProperty(PingRequest::class, 'method');

    expect($property->getValue($request))->toBe(Method::GET);
});

it('targets the health endpoint', function (): void {
    $request = new PingRequest;

    expect($request->resolveEndpoint())->toBe('/health');
});
