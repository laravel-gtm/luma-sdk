<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class PingRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/health';
    }
}
