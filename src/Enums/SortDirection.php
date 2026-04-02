<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum SortDirection: string
{
    case Asc = 'asc';
    case Desc = 'desc';
    case AscNullsLast = 'asc nulls last';
    case DescNullsLast = 'desc nulls last';
}
