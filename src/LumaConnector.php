<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk;

use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\MemoryStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AcceptsJson;

class LumaConnector extends Connector
{
    use AcceptsJson;
    use HasRateLimits;

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
        return rtrim($this->baseUrl ?? 'https://api.luma.ai', '/');
    }

    protected function defaultAuth(): ?TokenAuthenticator
    {
        if (empty($this->token)) {
            return null;
        }

        return new TokenAuthenticator($this->token);
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
