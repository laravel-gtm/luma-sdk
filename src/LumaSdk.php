<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk;

use LaravelGtm\LumaSdk\Requests\PingRequest;
use LaravelGtm\LumaSdk\Responses\PingResponse;

class LumaSdk
{
    public function __construct(private readonly LumaConnector $connector) {}

    public static function make(?string $baseUrl = null, ?string $token = null): self
    {
        return new self(new LumaConnector($baseUrl, $token));
    }

    public function ping(): PingResponse
    {
        $response = $this->connector->send(new PingRequest);
        /** @var array<string, mixed> $payload */
        $payload = $response->json();

        return PingResponse::fromArray($payload);
    }
}
