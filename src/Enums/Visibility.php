<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum Visibility: string
{
    case Public = 'public';
    case MembersOnly = 'members-only';
    case Private = 'private';
}
