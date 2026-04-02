<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum TicketPriceType: string
{
    case Free = 'free';
    case FiatPrice = 'fiat-price';
}
