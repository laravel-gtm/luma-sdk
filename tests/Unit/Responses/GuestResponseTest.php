<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\ApprovalStatus;
use LaravelGtm\LumaSdk\Responses\EventTicketResponse;
use LaravelGtm\LumaSdk\Responses\GuestResponse;
use LaravelGtm\LumaSdk\ValueObjects\LumaDate;

it('creates a guest response from array', function (): void {
    $response = GuestResponse::fromArray([
        'id' => 'gst_123',
        'user_id' => 'usr_456',
        'user_email' => 'guest@example.test',
        'user_name' => 'Test Guest',
        'user_first_name' => 'Test',
        'user_last_name' => 'Guest',
        'approval_status' => 'approved',
        'registered_at' => '2024-06-10T12:00:00.000Z',
        'event_tickets' => [
            [
                'id' => 'tkt_1',
                'amount' => 1000,
                'currency' => 'usd',
                'name' => 'General Admission',
            ],
        ],
        'event_ticket_orders' => [],
        'api_id' => 'gst_123',
    ]);

    expect($response->id)->toBe('gst_123');
    expect($response->approvalStatus)->toBe(ApprovalStatus::Approved);
    expect($response->registeredAt)->toBeInstanceOf(LumaDate::class);
    expect($response->eventTickets)->toHaveCount(1);
    expect($response->eventTickets[0])->toBeInstanceOf(EventTicketResponse::class);
    expect($response->eventTickets[0]->amount)->toBe(1000);
});

it('handles nullable guest fields', function (): void {
    $response = GuestResponse::fromArray([
        'id' => 'gst_789',
        'approval_status' => 'pending_approval',
    ]);

    expect($response->approvalStatus)->toBe(ApprovalStatus::PendingApproval);
    expect($response->userEmail)->toBeNull();
    expect($response->registeredAt)->toBeNull();
    expect($response->checkedInAt)->toBeNull();
    expect($response->eventTickets)->toBeEmpty();
});
