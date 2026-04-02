<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum WebhookStatus: string
{
    case Active = 'active';
    case Paused = 'paused';
}
