<?php

declare(strict_types=1);

namespace LaravelGtm\LumaSdk\Enums;

enum ApprovalStatus: string
{
    case Approved = 'approved';
    case Session = 'session';
    case PendingApproval = 'pending_approval';
    case Invited = 'invited';
    case Declined = 'declined';
    case Waitlist = 'waitlist';
}
