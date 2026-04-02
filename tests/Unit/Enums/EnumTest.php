<?php

declare(strict_types=1);

use LaravelGtm\LumaSdk\Enums\AccessInfoType;
use LaravelGtm\LumaSdk\Enums\ApprovalStatus;
use LaravelGtm\LumaSdk\Enums\EntityType;
use LaravelGtm\LumaSdk\Enums\MemberStatus;
use LaravelGtm\LumaSdk\Enums\SortDirection;
use LaravelGtm\LumaSdk\Enums\TicketPriceType;
use LaravelGtm\LumaSdk\Enums\Visibility;
use LaravelGtm\LumaSdk\Enums\WebhookStatus;

it('has correct approval status values', function (): void {
    expect(ApprovalStatus::Approved->value)->toBe('approved');
    expect(ApprovalStatus::PendingApproval->value)->toBe('pending_approval');
    expect(ApprovalStatus::Waitlist->value)->toBe('waitlist');
    expect(ApprovalStatus::from('declined'))->toBe(ApprovalStatus::Declined);
});

it('has correct visibility values', function (): void {
    expect(Visibility::Public->value)->toBe('public');
    expect(Visibility::MembersOnly->value)->toBe('members-only');
    expect(Visibility::Private->value)->toBe('private');
});

it('has correct webhook status values', function (): void {
    expect(WebhookStatus::Active->value)->toBe('active');
    expect(WebhookStatus::Paused->value)->toBe('paused');
});

it('has correct entity type values', function (): void {
    expect(EntityType::Calendar->value)->toBe('calendar');
    expect(EntityType::Event->value)->toBe('event');
});

it('has correct ticket price type values', function (): void {
    expect(TicketPriceType::Free->value)->toBe('free');
    expect(TicketPriceType::FiatPrice->value)->toBe('fiat-price');
});

it('has correct access info type values', function (): void {
    expect(AccessInfoType::Free->value)->toBe('free');
    expect(AccessInfoType::PaymentOnce->value)->toBe('payment-once');
    expect(AccessInfoType::PaymentRecurring->value)->toBe('payment-recurring');
});

it('has correct member status values', function (): void {
    expect(MemberStatus::Approved->value)->toBe('approved');
    expect(MemberStatus::ApprovedPendingPayment->value)->toBe('approved-pending-payment');
});

it('has correct sort direction values', function (): void {
    expect(SortDirection::Asc->value)->toBe('asc');
    expect(SortDirection::AscNullsLast->value)->toBe('asc nulls last');
});
