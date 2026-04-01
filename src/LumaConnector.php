<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class LumaConnector extends Connector
{
    use AcceptsJson;

    public function __construct(
        private readonly ?string $baseUrl = null,
        private readonly ?string $token = null,
    ) {}

    public function resolveBaseUrl(): string
    {
        return rtrim($this->baseUrl ?? 'https://api.luma.ai', '/');
    }

    protected function defaultAuth(): ?TokenAuthenticator
    {
        if (empty($this->token)) {
            return null;
        }

        return new TokenAuthenticator($this->token);
    }
}
