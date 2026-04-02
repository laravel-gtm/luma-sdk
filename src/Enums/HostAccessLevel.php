<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum HostAccessLevel: string
{
    case None = 'none';
    case CheckIn = 'check-in';
    case Manager = 'manager';
}
