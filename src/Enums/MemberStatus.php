<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum MemberStatus: string
{
    case Approved = 'approved';
    case Pending = 'pending';
    case ApprovedPendingPayment = 'approved-pending-payment';
    case Declined = 'declined';
}
