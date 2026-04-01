<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Tests;

use LaravelGtm\LumaSdk\Laravel\LumaServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [LumaServiceProvider::class];
    }
}
