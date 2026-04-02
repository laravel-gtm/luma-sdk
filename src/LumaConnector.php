<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk;

use Saloon\Http\Auth\HeaderAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;

class LumaConnector extends Connector
{
    use AlwaysThrowOnErrors;
    use HasRateLimits;
    use HasTimeout;

    protected int $connectTimeout = 10;

    protected int $requestTimeout = 30;

    private readonly ?RateLimitStore $customRateLimitStore;

    public function __construct(
        private readonly ?string $baseUrl = null,
        private readonly ?string $token = null,
        ?RateLimitStore $rateLimitStore = null,
    ) {
        $this->customRateLimitStore = $rateLimitStore;
    }

    public function resolveBaseUrl(): string
    {
        return rtrim($this->baseUrl ?? 'https://public-api.luma.com', '/');
    }

    protected function defaultAuth(): ?HeaderAuthenticator
    {
        if (empty($this->token)) {
            return null;
        }

        return new HeaderAuthenticator($this->token, 'x-luma-api-key');
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(500)->everyFiveMinutes()->name('luma-get'),
            Limit::allow(100)->everyFiveMinutes()->name('luma-post'),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return $this->customRateLimitStore ?? new MemoryStore;
    }

    protected function handleTooManyAttempts(Response $response, Limit $limit): void
    {
        if ($response->status() !== 429) {
            return;
        }

        $limit->exceeded(releaseInSeconds: 60);
    }
}
