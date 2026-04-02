<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum AccessInfoType: string
{
    case Free = 'free';
    case PaymentOnce = 'payment-once';
    case PaymentRecurring = 'payment-recurring';
}
