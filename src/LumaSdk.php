<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk;

use LaravelGtm\LumaSdk\Requests\GetSelfRequest;
use LaravelGtm\LumaSdk\Responses\UserResponse;

class LumaSdk
{
    public function __construct(private readonly LumaConnector $connector) {}

    public static function make(?string $baseUrl = null, ?string $token = null): self
    {
        return new self(new LumaConnector($baseUrl, $token));
    }

    public function getSelf(): UserResponse
    {
        $response = $this->connector->send(new GetSelfRequest);

        /** @var UserResponse */
        return $response->dtoOrFail();
    }
}
