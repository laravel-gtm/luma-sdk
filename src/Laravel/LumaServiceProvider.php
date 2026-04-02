<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Laravel;

use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\ServiceProvider;
use LaravelGtm\LumaSdk\LumaConnector;
use LaravelGtm\LumaSdk\LumaSdk;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;

class LumaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/luma.php', 'luma');

        $this->app->singleton(LumaConnector::class, function (): LumaConnector {
            $configRepository = $this->app->make(ConfigRepository::class);
            $cacheFactory = $this->app->make(CacheFactory::class);
            /** @var array<string, mixed> $config */
            $config = (array) $configRepository->get('luma', []);

            return new LumaConnector(
                $config['base_url'] ?? null,
                $config['token'] ?? null,
                new LaravelCacheStore($cacheFactory->store()),
            );
        });

        $this->app->singleton(LumaSdk::class, function (): LumaSdk {
            return new LumaSdk($this->app->make(LumaConnector::class));
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/luma.php' => $this->app->configPath('luma.php'),
            ], 'luma-config');
        }
    }
}
